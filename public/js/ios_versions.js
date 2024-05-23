function selectSubcategory() {
    $('.content .subcategory a').click(function() {
        $('.content p.subcategory a').each(function() {
            $(this).removeClass('selected');
        });
        $(this).addClass('selected');

        return false;
    });
}

function calcVersionDivWidth() {
    $('.content div.data div.month div.versions').each(function() {
        let versionsDivWidth = parseInt($(this).first().width());

        let biggestWidth = 0;
        let classes = '';
        let totalWidth = 0;
        $(this).find('div.version').each(function() {
            let version = $(this).attr('data-version');
            let percent = parseFloat($(this).attr('data-percent'));
            let width = Math.floor(versionsDivWidth / 100 * percent);
            totalWidth += width;
            if (biggestWidth < width) {
                let classlist = $(this).attr('class').split(/\s+/);
                classes = '.' + classlist.join('.');
                biggestWidth = width;
            }

            $(this).css('width', width + 'px');
            if (110 <= width) {
                $(this).html('iOS ' + version + ' - ' + percent + '%');
            } else if (50 <= width || (percent < 10 && 40 <= width)) {
                $(this).html(percent + '%');
            }
        });

        if (totalWidth < versionsDivWidth) {
            let widthDiff = versionsDivWidth - totalWidth;
            let biggestDiv = $(this).find('div' + classes);
            let biggestDivWidth = biggestWidth + widthDiff;
            biggestDiv.css('width', biggestDivWidth + 'px');
        }

        // console.log('versionsDivWidth ' + versionsDivWidth);
    });
}


$(document).ready(function() {
    selectSubcategory();
    calcVersionDivWidth();
});

$(window).resize(function() {
    calcVersionDivWidth();
});