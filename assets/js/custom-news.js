(function ($, document, window, undefined) {

    'use strict';

    var $holder = $('.custom-news-focus'),
        $articles = $('.custom-news-entry-content'),
        $excerpts = $('.custom-news-entry-content .news-excerpt'),
        activeArticle = undefined;
    //$answers = $('.faq-answer'),
    //$icons = $('.faq-icon');

    function init() {
        showFirstItemOnPageLoad();
        clickEventHandler();
    }

    function showFirstItemOnPageLoad() {
        var $item = $($articles[0]);

        moveItemIntoFocus($item);
    }

    function clickEventHandler() {
        $excerpts.on('click', function () {
            var $item = $(this.closest('.custom-news-entry-content'));

            returnItemToList();
            moveItemIntoFocus($item);
        });
    }

    function moveItemIntoFocus($item) {
        var $focusContent = $($item.find('img, .entry-title, .news-excerpt, .read-more'));
        var $title = $($item.find('.news-title'));

        activeArticle = $item.attr('id');
        $holder.append($focusContent);
        $title.show();
    }

    function returnItemToList() {
        var $items = $holder.contents();
        var $listLocation = $articles.filter('#' + activeArticle);
        var $title = $listLocation.find('.news-title');

        $title.hide();
        $listLocation.append($items);
    }

    $(document).ready(function () {
        init();
    });

}(jQuery, document, window));