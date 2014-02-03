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

({
    spanMin: 2,
    spanTotal: 12,
    spanStep: 1,
    format: function(value) {
        var metadata = this.model.get("metadata");
        return (metadata && metadata.components) ? metadata.components.length - 1 : 0;
    },
    _loadTemplate: function() {
        app.view.Field.prototype._loadTemplate.call(this);
        if(this.action !== 'edit') {
            this.template = app.template.empty;
        }
    },
    _render: function() {
        app.view.Field.prototype._render.call(this);
        if(this.action === 'edit' && this.value > 0) {
            var self = this,
                metadata = this.model.get("metadata");
            this.$('#layoutwidth').empty().noUiSlider('init', {
                    knobs: this.value,
                    scale: [0,this.spanTotal],
                    step: this.spanStep,
                    connect: false,
                    end: function(type) {
                        if(type !== 'move') {
                            var values = $(this).noUiSlider('value');
                            self.setValue(values);
                        }
                    }
                })
                .append(function(){
                    var html = "",
                        segments = (self.spanTotal / self.spanStep) + 1,
                        segmentWidth = $(this).width() / (segments - 1),
                        acum = 0;
                    _.times(segments, function(i){
                        acum = (segmentWidth * i) - 2;
                        html += "<div class='ticks' style='left:"+acum+"px'></div>";
                    }, this);
                    return html;
                });
            this.setSliderPosition(metadata);
        } else {
            this.$('.noUiSliderEnds').hide();
        }
    },
    setSliderPosition: function(metadata) {
        var divider = 0;
        _.each(_.pluck(metadata.components, 'width'), function(span, index) {
            if(index >= this.value) return;
            divider = divider + parseInt(span, 10);
            this.$('#layoutwidth').noUiSlider('move', {
                handle: index,
                to: divider
            });
        }, this);
    },
    setValue: function(value) {
        var metadata = this.model.get("metadata"),
            divider = 0;
        _.each(metadata.components, function(component, index){
            if(index == metadata.components.length - 1) {
                component.width = this.spanTotal - divider;
                if(component.width < this.spanMin) {
                    var adjustment = this.spanMin - component.width;
                    for(var i = index - 1; i >= 0; i--) {
                        metadata.components[i].width -= adjustment;
                        if(metadata.components[i].width < this.spanMin) {
                            adjustment = this.spanMin - metadata.components[i].width;
                            metadata.components[i].width = this.spanMin;
                        } else {
                            adjustment = 0;
                        }
                    }
                    component.width = this.spanMin;
                }
            } else {
                component.width = value[index] - divider;
                if(component.width < this.spanMin) {
                    component.width = this.spanMin;
                }
                divider += component.width;
            }
        }, this);
        this.setSliderPosition(metadata);
        this.model.set("metadata", metadata, {silent: true});
        this.model.trigger("change:layout");
    },
    bindDataChange: function() {
        if (this.model) {
            this.model.on("change:metadata", this.render, this);
        }
    },
    bindDomChange: function() {

    }
})
