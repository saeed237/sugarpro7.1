<?php
/*********************************************************************************
 * By installing or using this file, you are confirming on behalf of the entity
 * subscribed to the SugarCRM Inc. product ("Company") that Company is bound by
 * the SugarCRM Inc. Master Subscription Agreement (“MSA”), which is viewable at:
 * http://www.sugarcrm.com/master-subscription-agreement
 *
 * If Company is not bound by the MSA, then by installing or using this file
 * you are agreeing unconditionally that Company will be bound by the MSA and
 * certifying that you have authority to bind Company accordingly.
 *
 * Copyright (C) 2004-2013 SugarCRM Inc.  All rights reserved.
 ********************************************************************************/


/**
 * Searches through the installed relationships to find broken self referencing one-to-many relationships 
 * (wrong field used in the subpanel, and the left link not marked as left)
 */
function upgrade_custom_relationships($modules = array())
{
	global $current_user, $moduleList;
	if (!is_admin($current_user)) sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']); 
	
	require_once("modules/ModuleBuilder/parsers/relationships/DeployedRelationships.php");
	require_once("modules/ModuleBuilder/parsers/relationships/OneToManyRelationship.php");
	
	if (empty($modules))
		$modules = $moduleList;
	
	foreach($modules as $module)
	{
		$depRels = new DeployedRelationships($module);
		$relList = $depRels->getRelationshipList();
		foreach($relList as $relName)
		{
			$relObject = $depRels->get($relName);
			$def = $relObject->getDefinition();
			//We only need to fix self referencing one to many relationships
			if ($def['lhs_module'] == $def['rhs_module'] && $def['is_custom'] && $def['relationship_type'] == "one-to-many")
			{
				$layout_defs = array();
				if (!is_dir("custom/Extension/modules/$module/Ext/Layoutdefs") || !is_dir("custom/Extension/modules/$module/Ext/Vardefs"))
					continue;
				//Find the extension file containing the vardefs for this relationship
				foreach(scandir("custom/Extension/modules/$module/Ext/Vardefs") as $file)
				{
					if (substr($file,0,1) != "." && strtolower(substr($file, -4)) == ".php")
					{
						$dictionary = array($module => array("fields" => array()));
						$filePath = "custom/Extension/modules/$module/Ext/Vardefs/$file";
						include($filePath);
						if(isset($dictionary[$module]["fields"][$relName]))
						{
							$rhsDef = $dictionary[$module]["fields"][$relName];
							//Update the vardef for the left side link field
							if (!isset($rhsDef['side']) || $rhsDef['side'] != 'left')
							{
								$rhsDef['side'] = 'left';
								$fileContents = file_get_contents($filePath);
								$out = preg_replace(
									'/\$dictionary[\w"\'\[\]]*?' . $relName . '["\'\[\]]*?\s*?=\s*?array\s*?\(.*?\);/s',
									'$dictionary["' . $module . '"]["fields"]["' . $relName . '"]=' . var_export_helper($rhsDef) . ";",
									$fileContents
								);
								file_put_contents($filePath, $out);
							}
						}
					}
				}
				//Find the extension file containing the subpanel definition for this relationship
				foreach(scandir("custom/Extension/modules/$module/Ext/Layoutdefs") as $file)
				{
					if (substr($file,0,1) != "." && strtolower(substr($file, -4)) == ".php")
					{
						$layout_defs = array($module => array("subpanel_setup" => array()));
						$filePath = "custom/Extension/modules/$module/Ext/Layoutdefs/$file";
						include($filePath);
						foreach($layout_defs[$module]["subpanel_setup"] as $key => $subDef)
						{
							if ($layout_defs[$module]["subpanel_setup"][$key]['get_subpanel_data'] == $relName)
							{
								$fileContents = file_get_contents($filePath);
								$out = preg_replace(
									'/[\'"]get_subpanel_data[\'"]\s*=>\s*[\'"]' . $relName . '[\'"],/s',
									"'get_subpanel_data' => '{$def["join_key_lhs"]}',",
									$fileContents
								);
								file_put_contents($filePath, $out);
							}
						}
					}
				}
			}
		}
	}

    // Phase 2: Module builder has been incorrectly adding the id 
    // field attributes to created relationships
    foreach(glob('custom/Extension/modules/*/Ext/Vardefs/*.php') as $fileToFix) {
        $filename = basename($fileToFix);
        $dictionary = array();

        require($fileToFix);
        $tmp = array_keys($dictionary);
        if ( count($tmp) < 1 ) {
            // Empty dictionary
            continue;
        }
        $dictKey = $tmp[0];
        if ( !isset($dictionary[$dictKey]['fields']) ) {
            // Not modifying any fields, this isn't a relationship
            continue;
        }
        
        $isBadRelate = false;
        $idName = '';
        $linkField = null;
        $relateField = null;
        foreach ( $dictionary[$dictKey]['fields'] as $fieldName => $field ) {
            if ( isset($field['id_name']) && $fieldName != $field['id_name'] ) {
                if ( isset($field['type']) && $field['type'] == 'link' ) {
                    // This looks promising
                    if ( isset($dictionary[$dictKey]['fields'][$field['id_name']]) ) {
                        $idField = $dictionary[$dictKey]['fields'][$field['id_name']];
                        if ( isset($idField['type']) && $idField['type'] == 'link' ) {
                            // This looks like a winner
                            $idName = $field['id_name'];
                            $isBadRelate = true;
                            $linkField = $field;
                        }
                    }
                }
                if ( isset($field['type']) && $field['type'] == 'relate' ) {
                    $relateField = $field;
                }
            }
        }

        if ( !$isBadRelate ) {
            continue;
        }
                
		$depRels = new DeployedRelationships($dictKey);
        $relObj = $depRels->get($linkField['relationship']);
        if ( !$relObj ) {
            // The system doesn't know about the relationship object.
            $linkMetadataLocation = 'custom/metadata/'.$linkField['relationship'].'MetaData.php';
            if ( file_exists($linkMetadataLocation) ) {
                require $linkMetadataLocation;
                $linkDef = $dictionary[$linkField['relationship']];
                $relObj = RelationshipFactory::newRelationship($linkDef);
            }
        }

        $newIdField = array(
            'name' => $idName,
            'type' => 'id',
            'source' => 'non-db',
            'vname' => $idField['vname'],
            'id_name' => $idName,
            'link' => $relateField['link'],
            'table' => $relateField['table'],
            'module' => $relateField['module'],
            'rname' => 'id',
            'reportable' => false,
            'massupdate' => false,
            'duplicate_merge' => 'disabled',
            'hideacl' => true,
        );
        if ( $relObj && $relObj->getLhsModule() == $relObj->getRhsModule() ) {
            $selfReferencing = true;
        } else {
            $selfReferencing = false;
        }

        if ( $selfReferencing ) {
            $leftLinkName = $relateField['link'];
            $newIdField['link'] = $relateField['link'].'_right';
            $relateField['link'] = $newIdField['link'];
            $newLinkField = array(
                'name' => $relateField['link'],
                'type' => 'link',
                'relationship' => $linkField['relationship'],
                'source' => 'non-db',
                'vname' => $idField['vname'],
                'id_name' => $relObj->getJoinKeyRHS(),
                'side' => 'right',
            );
        }
            
        $replaceString = '$dictionary["' . $dictKey . '"]["fields"]["' . $idName . '"]=' . var_export_helper($newIdField) . ";\n";
        if ( $selfReferencing ) {
            $replaceString .= '$dictionary["'. $dictKey .'"]["fields"]["'. $newLinkField['name'] .'"]=' . var_export_helper($newLinkField) .";\n";
        }

        $fileContents = file_get_contents($fileToFix);
        $out = preg_replace(
            '/\$dictionary[\w"\'\[\]]*?' . $idName . '["\'\[\]]*?\s*?=\s*?array\s*?\(.*?\);/s',
            $replaceString,
            $fileContents
        );
        if ( $selfReferencing ) {
            $out = preg_replace(
                '/\$dictionary[\w"\'\[\]]*?' . $relateField['name'] . '["\'\[\]]*?\s*?=\s*?array\s*?\(.*?\);/s',
                '$dictionary["' . $dictKey . '"]["fields"]["' . $relateField['name'] . '"]=' . var_export_helper($relateField) . ";\n",
                $out
            );

        }
        file_put_contents($fileToFix, $out);

        if ( $selfReferencing ) {
            // Now to fix bad layouts in self-linking relationships
            // Go to the Layoutdefs path
            $layoutPath = dirname(dirname($fileToFix)).'/Layoutdefs';
            foreach(glob($layoutPath.'/*.php') as $layoutToCheck) {
                // See if they match the id I just changed.
                $layoutContents = file_get_contents($layoutToCheck);
                if ( preg_match('/\$layout_defs[^=]*subpanel_setup[^=]*'.$idName.'[^=]*= array/',$layoutContents) ) {
                    $layoutContents = str_replace($idName,$leftLinkName,$layoutContents);
                    file_put_contents($layoutToCheck,$layoutContents);
                }
            }
        }
    }
    
}
if (isset($_REQUEST['execute']) && $_REQUEST['execute'])
	upgrade_custom_relationships();