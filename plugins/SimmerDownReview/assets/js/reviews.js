/**
 * Budget Recipes – Post & Reviews
 * assets/js/reviews.js
 * Interactive behaviours: tab switching, star hover, budget selector
 */
(function($) {
    'use strict';

    /* =====================================================
       TAB SWITCHER
       (Used in page-post-reviews.php template)
       ===================================================== */
    $(document).on('click', '.review-tab-btn', function() {
        var target = $(this).data('tab');
        $('.review-tab-btn').removeClass('active');
        $(this).addClass('active');
        $('.review-tab-panel').removeClass('active');
        $('#' + target).addClass('active');
        // Smooth scroll to panel top
        $('html, body').animate({ scrollTop: $('.review-tabs').offset().top - 80 }, 300);
    });

    /* =====================================================
       BUDGET PICKER – visual toggle
       ===================================================== */
    $(document).on('change', '.review-budget-btn input', function() {
        var $group = $(this).closest('.review-budget-picker');
        $group.find('.review-budget-btn').removeClass('selected');
        $(this).closest('.review-budget-btn').addClass('selected');
    });

    /* =====================================================
       FORM VALIDATION FEEDBACK
       ===================================================== */
    $(document).on('submit', '.review-form', function(e) {
        var $form = $(this);
        var ratingChecked = $form.find('input[name="review_f_rating"]:checked').length;
        var budgetChecked = $form.find('input[name="review_f_budget"]:checked').length;
        var errors = [];

        if (!ratingChecked) errors.push('Overall Rating');
        if (!budgetChecked) errors.push('Budget Score');

        if (errors.length) {
            e.preventDefault();
            var msg = 'Please select: ' + errors.join(' and ') + '.';
            var $existing = $form.find('.review-msg.error');
            if ($existing.length) {
                $existing.text(msg);
            } else {
                $form.prepend('<div class="review-msg error">' + msg + '</div>');
            }
            $('html,body').animate({ scrollTop: $form.offset().top - 80 }, 300);
        }
    });

    /* =====================================================
       REVIEW CARD TOOLTIP – show budget meaning on hover
       ===================================================== */
    var budgetLabels = { 1:'Very Cheap', 2:'Cheap', 3:'Moderate', 4:'Somewhat Pricey', 5:'Moderate+' };

    $(document).on('mouseenter', '.review-budget-label', function() {
        var score = $(this).text().trim().length; // number of $ chars
        var label = budgetLabels[score] || 'Budget Info';
        $(this).attr('title', label);
    });

})(jQuery);
