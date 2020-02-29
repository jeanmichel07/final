/** Custom Scripts */
var loadTime = 2000;
(function ($, window, document) {
    $(function () {
        setTimeout(() => {
            const $preloader = $('#preloader');
            $preloader.addClass('hidden');
            setTimeout(() => {
                $preloader.addClass('finished');
            }, 1500);
        }, loadTime);
        const $document = $(document);
        $document.on('click', '.dropdown-item.text-danger', (e) => {
            e.preventDefault();
            if (!confirm('Voulez-vous effectuer cette action ?')) return;
        });
    });
}(window.jQuery, window, window.document));