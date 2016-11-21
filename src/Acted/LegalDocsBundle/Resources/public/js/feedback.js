(function ($) {
    'use strict';

    function changeOnHover() {
        var $this = $(this);
        var $wrapper = $this.parent();
        var $prevStars = $this.prevAll();

        if (!$wrapper.hasClass('rating-fixed')) {
            $this.toggleClass('unfilled').toggleClass('filled');
            $prevStars.toggleClass('unfilled').toggleClass('filled');
        }
    }

    function setFixed() {
        var $this = $(this);
        var $wrapper = $this.parent();
        var $prevStars = $this.prevAll();

        $this.removeClass('unfilled').addClass('filled');
        $prevStars.removeClass('unfilled').addClass('filled');
        $wrapper.addClass('rating-fixed');
        $wrapper.find('button').removeClass('disabled');
    }

    function getRating($commentBox) {
        return $commentBox.find('i.filled').lenght;
    }

    function charsCounter() {
        var $this = $(this);
        var $wrapper = $this.parents('.comment-box');
        var $current = $wrapper.find('.current-count');

        $current.html($this.val().length);
    }

    function collectData($commentBox) {
        var rating = getRating($commentBox);
        var text = $commentBox.find('textarea').val();

        return JSON.stringify({rating: rating, text: text});
    }

    function sendFeedback() {
        var $this = $(this);
        if(!$this.hasClass('disabled')){
            var $wrapper = $this.parents('.comment-box');
            var data = collectData($wrapper);
            $.ajax({
                //todo implement ajax
            });
        }
    }

    $('.star-icon').hover(changeOnHover).click(setFixed);
    $('.comment-box > textarea').keyup(charsCounter);
    $('.comment-box >button').click(sendFeedback);


})(jQuery);