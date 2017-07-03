define('modals', function(require) {

    var setting = {
        id: '',
        data: '',//[modal:弹层填充位置, source: ajax请求路径]
        element: '',
        modalHtml: '<div id="ajax-modal"  class="modal fade" tabindex="-1"></div>'
    };
    var $modal = null;
    var callback = function(){};
    var Modal = function() {};

    Modal.prototype.init = function(selector) {

        setting.element = $(selector);
        setting.data = setting.element.data();

        setting.modalHtml = '<div id="' + setting.data.modal + '"  class="modal fade bs-modal-lg in" role="dialog"  tabindex="-1"></div>';
        $.fn.modal.defaults.spinner = $.fn.modalmanager.defaults.spinner =
            '<div class="loading-spinner" style="width: 200px; margin-left: -100px;">' +
            '<div class="progress progress-striped active">' +
            '<div class="progress-bar" style="width: 100%;"></div>' +
            '</div>' +
            '</div>';

        $.fn.modalmanager.defaults.resize = true;
        //ajax demo:
        $('.page-content-wrapper .page-content').append(setting.modalHtml);
        $modal = $('#' + setting.data.modal);

        setting.element.on('click', function() {
            var _self = $(this);
            // create the backdrop and wait for next modal to be triggered
            $('body').modalmanager('loading');

            setTimeout(function() {
                $modal.load(_self.attr('data-source'), '', function() {
                    
                    $modal.modal();
                    require(['core'], function(Core){
                        console.log('modals module');
                        Core.Core.rebind('modals', false);
                        for (var key in requireConfig.paths) {
                            if (document.querySelector('[data-modules="' + key + '"]')) {
                                Core.Core.reset(key);
                            }
                        }
                        
                    });
                });
            }, 1000);
        });

        $modal.on('click', '.update', function() {
            $modal.modal('loading');
            setTimeout(function() {
                $modal
                    .modal('loading')
                    .find('.modal-body')
                    .prepend('<div class="alert alert-info fade in">' +
                        'Updated!<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '</div>');
            }, 1000);
        });
    };

    Modal.prototype.getModal = function(){
        return $modal;
    }

    Modal.prototype.callback = function(handle){

        if(typeof handle != 'function') return;
        console.log(typeof handle != 'function', typeof handle)
        callback = handle;
        Modal.call(handle, $modal);
    }

    return {
        name: 'modals',
        module: (new Modal())
    };
});
