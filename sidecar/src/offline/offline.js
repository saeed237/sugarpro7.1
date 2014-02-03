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

(function(app) {

    var _sqlHelpers, _db;

    // -------- CRUD --------------------------------------------------------

    var _create = function(bean, success, failure, options) {
        bean.id = _generateUUID();

        var _create = function(tx) {
            _db.executeSql(tx, _sqlHelpers[bean.beanType].sqlCreate, _getValues(bean));
        };

        _dispatch(options, _create, success, failure);
    };

    var _update = function(bean, success, failure, options) {
        var sql, values = _getValues(bean);
        if (bean.id != options.oldId) {
            values.push(options.oldId || bean.id);
            sql = _sqlHelpers[bean.beanType].sqlUpdate;
        }
        else {
            sql = _sqlHelpers[bean.beanType].sqlReplace;
        }
        var _update = function(tx) {
            _db.executeSql(tx, sql, values);
            // TODO: Implement relationships
        };

        _dispatch(options, _update, success, failure);
    };

    var _destroy = function(bean, success, failure, options) {
        var _destroy = function(tx) {
            _db.executeSql(tx, _sqlHelpers[bean.beanType].sqlDelete, [bean.id]);
            // TODO: Remove relationships
        };

        _dispatch(options, _destroy, success, failure);
    };

    var _read = function(bean, success, failure) {
        _db.executeSql(undefined, _sqlHelpers[bean.beanType].sqlSelectOne, [bean.id], success, failure);
    };

    var _readMany = function(beans, options, success, failure) {
        var params, sql = _sqlHelpers[beans.beanType].buildSqlSelectMany(options);
        // TODO: Build params
        _db.executeSql(undefined, sql, params, success, failure);
    };

    var _dispatch = function(options, func, success, failure) {
        if (options.tx) {
            func.call(this, options.tx);
        }
        else {
            _db.executeInTransaction(function(tx) {
                func.call(this, tx);
            }, success, failure);
        }

    };

    //-----------------------------------------------------------------------

    var _getValues = function(bean) {
        var values = [bean.id, bean.syncState, bean.modifiedAt],
            value;
        _.each(_sqlHelpers[bean.beanType].fields, function(field) {
            value = bean.get(field.name);
            value = _.isUndefined(value) ? null : value;
            values.push(value);
        });
        return values;
    };

    var _recordSetToArray = function(recordSet) {
        var results = [];
        if (recordSet) {
            for (var i = 0; i < recordSet.rows.length; i++) {
                results.push(recordSet.rows.item(i));
            }
        }
        return results;
    };

    // TODO: Revisit and move to util module
    // http://stackoverflow.com/questions/105034/how-to-create-a-guid-uuid-in-javascript
    var _generateUUID = function() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    };

    app.augment("Offline", {

        init: function() {
            Backbone.sync = app.Offline.dataManager.sync;
        },

        DbError: function(code, message) {
            this.code = code;
            this.message = message;
        },

        storageAdapter: {

            open: function() {
                var name = app.config.dbName + "-" + app.config.env;
                var size = app.config.dbSize * 1024 * 1024;
                var version = "1.0";

                try {
                    _db = app[app.config.db];
                    _db.open(name, version, size);
                }
                catch (e) {
                    _db = null;
                    app.logger.fatal("Failed to open database: " +  name + ' ' + version + ' (' + size + ' bytes)');
                    return false;
                }

                return true;
            },

            migrate: function(metadata, oldMetadata, success, failure) {
                _sqlHelpers = {};
                // TODO: Implement migration

                var beans, sqlHelper, statements = [];
                _.each(_.keys(metadata), function(moduleName) {
                    beans = metadata[moduleName].beans;
                    _.each(_.keys(beans), function(beanType) {
                        sqlHelper = new app.Offline.SqlHelper(beanType, beans[beanType]);
                        _sqlHelpers[beanType] = sqlHelper;
                        statements.push(sqlHelper.getSchema(beanType, beans[beanType]));
                    }, this);
                }, this);

                _db.executeStatements(null, _.flatten(statements), success, failure);
            },

            sync: function(method, bean, options) {
                app.logger.trace("storageAdapter: " + method + '-' + bean.module + '-' + bean.id);
                options = options || {};

                var successCallback;
                var success = function(tx, recordSet) {
                    if (options.success) {
                        if (successCallback) successCallback(tx, recordSet);
                        else options.success();
                    }
                };

                // TODO: Revisit failure callback
                var failure = function(tx, error) {
                    if (!error) error = tx;
                    if (options.error) options.error(new app.Offline.DbError(error.code, error.message));
                };

                switch (method) {
                    case "read":
                        if (bean.id) {
                            successCallback = function(tx, recordSet) {
                                if (options.success) {
                                    options.success(recordSet && recordSet.rows.length > 0 ? recordSet.rows.item(0) : undefined);
                                }
                            };
                            _read(bean, success, failure);
                        }
                        else {
                            successCallback = function(tx, recordSet) {
                                if (options.success) {
                                    options.success(_recordSetToArray(recordSet));
                                }
                            };
                            _readMany(bean, options, success, failure);
                        }
                        break;
                    case "create":
                        _create(bean, success, failure, options);
                        break;
                    case "update":
                        _update(bean, success, failure, options);
                        break;
                    case "delete":
                        _destroy(bean, success, failure, options);
                        break;
                }
            }

        },

        /**
         * Helper class to build SQL statements and database schema for a given module/bean type.
         * @param name bean type
         * @param definition bean metadata
         * @ignore
         */
        SqlHelper: function(name, definition) {
            this.name = name;
            this.definition = definition;
            this._tableName = 'd_' + name;

            this.fields = _.select(_.values(definition.vardefs.fields), function(field) {
                return field.type != "link" && field.name != "id";
            });

            // Build SQL statements

            var columns = _.map(this.fields, function(column) {
                return '"' + column.name + '"';
            });
            columns.unshift('"_modified_at"');
            columns.unshift('"_sync_state"');
            columns.unshift('"id"');

            var columnsSet = _.map(columns, function(column) {
                return column + "=?";
            });

            var columnsString = '(' + columns.join(',') + ')';
            var updateColumns = "SET " + columnsSet.join(',');
            var q = [];
            _.times(columns.length, function() {
                q.push('?');
            });
            var valuesString = '(' + q.join(',') + ')';

            this.sqlCreate = 'INSERT INTO "' + this._tableName + '" ' + columnsString + ' VALUES ' + valuesString;
            this.sqlReplace = 'REPLACE INTO "' + this._tableName + '" ' + columnsString + ' VALUES ' + valuesString;
            this.sqlUpdate = 'UPDATE "' + this._tableName + '" ' + updateColumns + ' WHERE id=?';
            this.sqlDelete = 'DELETE FROM "' + this._tableName + '" WHERE id=?';
            this.sqlSelectOne = 'SELECT * FROM "' + this._tableName + '" WHERE id=?';
            this.sqlSelectMany = 'SELECT * FROM "' + this._tableName + '"';
        }

    });

    _.extend(app.Offline.SqlHelper.prototype, {

        getSchema: function(oldFields) {
            // TODO: Implement migration

            var statements = [], columns = [], indices = [];

            columns.push('"id" TEXT PRIMARY KEY COLLATE NOCASE');
            columns.push('"_sync_state" INTEGER');
            columns.push('"_modified_at" INTEGER');

            _.each(this.fields, function(field) {
                var type;
                // TODO: Revisit types
                switch (field.type) {
                    case "boolean":
                    case "int":
                        type = ' INTEGER';
                        break;
                    case "float":
                    case "double":
                    case "currency":
                        type = ' REAL';
                        break;
                    default:
                        type = ' TEXT COLLATE NOCASE';
                        break;
                }
                columns.push('"' + field.name + '"' + type);

                if (field.unified_search === true) {
                    var indexName = this.name + '_' + field.name + '_IDX';
                    indices.push('DROP INDEX IF EXISTS ' + indexName);
                    indices.push('CREATE INDEX ' + indexName + ' ON "' + this._tableName + '" ("' + field.name + '" COLLATE NOCASE)');
                }
            }, this);

            statements.push('DROP TABLE IF EXISTS "' + this._tableName + '"');
            statements.push('CREATE TABLE "' + this._tableName + '" (' + columns.join(',') + ')');
            _.each(indices, function(index) {
                statements.push(index);
            });

            return statements;
        },

        buildSqlSelectMany: function(options) {
            // TODO: options may contain pagination params and field list
            return this.sqlSelectMany;
        }

    });

})(SUGAR.App);