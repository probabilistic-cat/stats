function selectSubcategory() {
    $('.content .subcategory a').click(function() {
        $('.content p.subcategory a').each(function() {
            $(this).removeClass('selected');
        });
        $(this).addClass('selected');

        return false;
    });
}

$(document).ready(function() {
    selectSubcategory();
});