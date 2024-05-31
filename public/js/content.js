let isMinorShown = false;

//function selectSubcategory() {
//    $('.content .subcategory a').click(function() {
//        $('.content p.subcategory a').each(function() {
//            $(this).removeClass('selected');
//        });
//        $(this).addClass('selected');
//
//        return false;
//    });
//}

function calcVersionDivWidth() {
    let prevYear = 0;
    $('.content div.data div.month div.versions').each(function() {
        let divMonth = $(this).parent();
        let curYear = divMonth.attr('data-year');
        if (curYear !== prevYear && prevYear !== 0) {
            divMonth.css('margin-top', '20px');
        }
        prevYear = curYear;

        let versionsDivWidth = parseInt($(this).first().width());

        let biggestWidth = 0;
        let classes = '';
        let totalWidth = 0;
        let isFirstVersionDiv = true;
        $(this).find('div.version').each(function() {
            // let name = $(this).attr('data-name');
            let percent = parseFloat($(this).attr('data-percent'));
            let width = Math.floor(versionsDivWidth / 100 * percent);
            if (width === 1) {
                width = 0;
            }

            totalWidth += width;
            if (biggestWidth < width) {
                let classlist = $(this).attr('class').split(/\s+/);
                classes = '.' + classlist.join('.');
                biggestWidth = width;
            }

            $(this).css('width', width + 'px');
            if (isFirstVersionDiv) {
                $(this).css('box-shadow', 'none');
                if (width > 1) {
                    isFirstVersionDiv = false;
                }
            }

            let pTitle = $(this).find('p.version_title');
            if (!isMinorShown) {
                let fullTitle = $(this).attr('title');
                let shortTitle = percent + '%';
                if (fullTitle.length * 8 < width) {
                    pTitle.html(fullTitle);
                    pTitle.show();
                } else if (shortTitle.length * 9 < width) {
                    pTitle.html(shortTitle);
                    pTitle.show();
                }

                $(this).find('div.minor_version').each(function() {
                    $(this).hide();
                });
            } else {
                pTitle.hide();
            }
        });

        if (totalWidth < versionsDivWidth) {
            let widthDiff = versionsDivWidth - totalWidth;
            let biggestDiv = $(this).find('div' + classes);
            let biggestDivWidth = biggestWidth + widthDiff;
            biggestDiv.css('width', biggestDivWidth + 'px');
        }

        if (!isMinorShown) {
            return;
        }

        // minor versions divs
        $(this).find('div.version').each(function() {
            let width = $(this).width();
            let percent = parseFloat($(this).attr('data-percent'));

            let minorBiggestWidth = 0;
            let minorClasses = '';
            let minorTotalWidth = 0;
            $(this).find('div.minor_version').each(function() {
                let minorPercent = parseFloat($(this).attr('data-percent'));
                let minorWidth = Math.floor(width / percent * minorPercent);
                if (minorWidth === 1) {
                    minorWidth = 0;
                }

                minorTotalWidth += minorWidth;
                if (minorBiggestWidth < minorWidth) {
                    let minorClasslist = $(this).attr('class').split(/\s+/);
                    for (let i = 0; i < minorClasslist.length; i++) {
                        minorClasslist[i] = minorClasslist[i].replace(".", "\\.");
                    }
                    minorClasses = '.' + minorClasslist.join('.');
                    minorBiggestWidth = minorWidth;
                }

                $(this).css('width', minorWidth + 'px');
                $(this).show();

                let pMinorTitle = $(this).find('p.minor_version_title');
                let fullTitle = $(this).attr('title');
                let shortTitle = minorPercent + '%';
                if (fullTitle.length * 8 < minorWidth) {
                    pMinorTitle.html(fullTitle);
                    pMinorTitle.show();
                } else if (shortTitle.length * 9 < minorWidth) {
                    pMinorTitle.html(shortTitle);
                    pMinorTitle.show();
                }
            });

            if (minorTotalWidth < width) {
                let widthDiff = width - minorTotalWidth;
                let biggestDiv = $(this).find('div' + minorClasses);
                let biggestDivWidth = minorBiggestWidth + widthDiff;
                biggestDiv.css('width', biggestDivWidth + 'px');
            }
        });
    });
}

function showMinorButton() {
    let aShowMinor = $('.content div.show_minor a.show');
    let aHideMinor = $('.content div.show_minor a.hide');

    aShowMinor.click(function() {
        aShowMinor.hide();
        aHideMinor.show();
        isMinorShown = true;
        calcVersionDivWidth();
        return false;
    });

    aHideMinor.click(function() {
        aHideMinor.hide();
        aShowMinor.show();
        isMinorShown = false;
        calcVersionDivWidth();
        return false;
    });
}


$(document).ready(function() {
    showMinorButton();
    //selectSubcategory();
    calcVersionDivWidth();
});

$(window).resize(function() {
    calcVersionDivWidth();
});