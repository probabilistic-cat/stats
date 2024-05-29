let isMinorShown = false;

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
        let isFirstVersionDiv = true;
        $(this).find('div.version').each(function() {
            // let version = $(this).attr('data-version');
            let percent = parseFloat($(this).attr('data-percent'));
            let width = Math.floor(versionsDivWidth / 100 * percent);
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
                if (110 <= width) {
                    pTitle.html($(this).attr('title'));
                    pTitle.show();
                } else if (50 <= width || (percent < 10 && 42 <= width)) {
                    pTitle.html(percent + '%');
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
                if (120 <= minorWidth) {
                    pMinorTitle.html($(this).attr('title'));
                    pMinorTitle.show();
                } else if (50 <= minorWidth || (minorPercent < 10 && 42 <= minorWidth)) {
                    pMinorTitle.html(minorPercent + '%');
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
    $('.content p.show_minor').click(function() {
        if (!isMinorShown) {
            $(this).html('hide minor versions')
            isMinorShown = true;
        } else {
            $(this).html('show minor versions')
            isMinorShown = false;
        }
        calcVersionDivWidth();
    });
}


$(document).ready(function() {
    showMinorButton();
    selectSubcategory();
    calcVersionDivWidth();
});

$(window).resize(function() {
    calcVersionDivWidth();
});