/**
 * Created by gbmcarlos on 11/14/17.
 */
(function(window, jQuery){

    var IndexPageController = {

        $: jQuery,

        ui: {
            randomPatternButton: jQuery('#randomPatternButton'),
            gospersGliderGunButton: jQuery('#gospersGliderGunButton'),
            loadingLabel: jQuery('#loadingLabel')
        },

        init: function() {
            this.setEvents();
        },

        setEvents: function(){

            this.ui.randomPatternButton.on('click', this.redirect.bind(this));
            this.ui.gospersGliderGunButton.on('click', this.redirect.bind(this));

        },

        redirect: function(event) {

            var element = this.$(event.currentTarget);
            var redirectUrl = element.attr('data-href');

            this.showLabel();

            location.href = redirectUrl;

        },

        showLabel: function() {
            this.ui.loadingLabel.show();
        }

    };

    window.IndexPageController = IndexPageController;

    window.IndexPageController.init();

})(window, jQuery);