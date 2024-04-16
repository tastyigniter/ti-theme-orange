/*
 * The menu item editor. Provides tools for managing the
 * menu items.
 */
+function ($) {
    "use strict";

    var MenuItemsEditor = function (el, options) {
        this.$el = $(el)
        this.options = options

        this.init()
    }

    MenuItemsEditor.prototype.init = function () {
        this.alias = this.$el.data('alias')
        this.typeInfo = {}

        this.$el.on('click', '[data-control="load-item"]', $.proxy(this.loadProperties, this))

        $(window).on('recordEditorModalShown', $.proxy(this.onModalLoaded, this))

        $(document).on('change', 'select[data-toggle="menu-item-type"]', $.proxy(this.onChangeType, this))
    }

    MenuItemsEditor.prototype.onChangeType = function (event) {
        var self = this,
            $el = $(event.target),
            type = $el.val()

        if (this.typeInfo[type] !== undefined) {
            self.applyTypeInfo(this.typeInfo[type], type)
            return
        }

        $el.prop('disabled', true)
        $.ti.loadingIndicator.show()
        $.request($el.data('handler'), {
            data: {type: type, recordId: this.$modalElement.find('[name="recordId"]').val()}
        }).always(function () {
            $el.prop('disabled', false)
            $.ti.loadingIndicator.hide()
        }).done(function (json) {
            self.typeInfo[type] = json.menuItemTypeInfo
            self.applyTypeInfo(json.menuItemTypeInfo, type)
        })
    }

    MenuItemsEditor.prototype.applyTypeInfo = function (typeInfo, type) {
        var $modalElement = this.$modalElement,
            $urlFormGroup = $('div[data-field-name="url"]', $modalElement)

        this.applyTypeInfoReferences(typeInfo.references, $modalElement)

        $urlFormGroup.toggle(type === 'url')

        $(document).trigger('render')
    }

    MenuItemsEditor.prototype.applyTypeInfoReferences = function (references, $modalEl) {
        var $reference = $('div[data-field-name="reference"]', $modalEl),
            $selector = $('select', $reference),
            selected = $selector.val()

        selected = selected ? selected : this.properties.reference

        if (references) {
            $selector.find('option').remove()
            $reference.show()

            $.each(references, function (index, code) {
                var $option = $('<option></option>').attr('value', index)

                if (selected === index)
                    $option.attr('selected', true)

                $option.text(code).val(index)
                $selector.append($option)
            })
        } else {
            $reference.hide()
        }
    }

    MenuItemsEditor.prototype.onModalLoaded = function (event, $modalEl) {
        this.$modalElement = $modalEl

        $modalEl.find('.form-group-hide').hide()
        $modalEl.find('select[data-toggle="menu-item-type"]').trigger('change')
    }

    MenuItemsEditor.prototype.loadProperties = function (event) {
        var $button = $(event.currentTarget)

        this.properties = $button.find('[data-properties]').data('properties')
    }

    MenuItemsEditor.DEFAULTS = {}

    // MENUITEMSEDITOR PLUGIN DEFINITION
    // ============================

    var old = $.fn.menuItemsEditor

    $.fn.menuItemsEditor = function (option) {
        var args = Array.prototype.slice.call(arguments, 1)
        return this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.menuitemseditor')
            var options = $.extend({}, MenuItemsEditor.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.menuitemseditor', (data = new MenuItemsEditor(this, options)))
            else if (typeof option == 'string') data[option].apply(data, args)
        })
    }

    $.fn.menuItemsEditor.Constructor = MenuItemsEditor

    // MENUITEMSEDITOR NO CONFLICT
    // =================

    $.fn.menuItemsEditor.noConflict = function () {
        $.fn.menuItemsEditor = old
        return this
    }

    // MENUITEMSEDITOR DATA-API
    // ===============

    $(document).on('render', function () {
        $('[data-control="menu-item-editor"]').menuItemsEditor()
    });
}(window.jQuery);
