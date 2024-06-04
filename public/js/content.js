let classDataMonthVersionMajor = 'version_major';
let classDataMonthVersionMinor = 'version_minor';

let isMajorShown = true;
let hasMinor = false;

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
            if (isMajorShown) {
                let fullTitle = $(this).attr('title');
                let shortTitle = percent + '%';
                if (fullTitle.length * 8 < width) {
                    pTitle.html(fullTitle);
                    pTitle.show();
                } else if (shortTitle.length * 9 < width) {
                    pTitle.html(shortTitle);
                    pTitle.show();
                }

                $(this).find('div.version_minor').each(function() {
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

        if (isMajorShown) {
            return;
        }

        // minor versions divs
        $(this).find('div.version').each(function() {
            let width = $(this).width();
            let percent = parseFloat($(this).attr('data-percent'));

            let minorBiggestWidth = 0;
            let minorClasses = '';
            let minorTotalWidth = 0;
            $(this).find('div.version_minor').each(function() {
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

                let pMinorTitle = $(this).find('p.version_minor_title');
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

function setMinor() {
    hasMinor = (parseInt($('.content div.category').attr('data-has_minor')) === 1);
}

function majorMinorButton() {
    let aShowMinor = $('.content div.show_major_minor a.show_minor');
    let aShowMajor = $('.content div.show_major_minor a.show_major');

    aShowMinor.click(function() {
        aShowMinor.hide();
        aShowMajor.show();
        isMajorShown = false;
        calcVersionDivWidth();
        return false;
    });

    aShowMajor.click(function() {
        aShowMajor.hide();
        aShowMinor.show();
        isMajorShown = true;
        calcVersionDivWidth();
        return false;
    });
}

function dataMonthMajorMinorButton() {
    let divDataMonth = $('div.data_month');
    let aShowMinor = divDataMonth.find('div.show_major_minor a.show_minor');
    let aShowMajor = divDataMonth.find('div.show_major_minor a.show_major');

    if (!hasMinor) {
        aShowMinor.hide();
        aShowMajor.hide();
        return;
    }

    aShowMinor.click(function() {
        divDataMonth.find('div.month div.version.' + classDataMonthVersionMajor).hide();
        divDataMonth.find('div.month div.version.' + classDataMonthVersionMinor).show();
        aShowMinor.hide();
        aShowMajor.show();
        return false;
    });

    aShowMajor.click(function() {
        divDataMonth.find('div.month div.version.' + classDataMonthVersionMinor).hide();
        divDataMonth.find('div.month div.version.' + classDataMonthVersionMajor).show();
        aShowMajor.hide();
        aShowMinor.show();
        return false;
    });
}

function dataMonthOpen(year, monthName) {
    $('div.overlay_body').show();
    $('div.data_month').show();
}

function dataMonthClose() {
    $('div.data_month').hide();
    $('div.overlay_body').hide();
}

function dataMonthOpenFields() {
    $('.content div.data div.month div.versions').click(function() {
        let divMonth = $(this).parent();
        let year = divMonth.attr('data-year');
        let monthName = divMonth.attr('data-month_name');
        let date = year + ' ' + monthName;

        let versionsMajor = [];
        let versionsMinor = [];

        $(this).find('div.version').each(function () {
            versionsMajor.push(getVersionAttrs($(this)));

            let minorVersionsCount = 0;
            $(this).find('div.version_minor').each(function() {
                versionsMinor.push(getVersionAttrs($(this)));
                minorVersionsCount++;
            });
            if (minorVersionsCount === 0) {
                versionsMinor.push(getVersionAttrs($(this)));
            }
        });

        dataMonthFill(date, versionsMajor, versionsMinor)
        dataMonthOpen();
    });
}

function getVersionAttrs(divVersion) {
    return {
        'name': divVersion.attr('data-name'),
        'percent': parseFloat(divVersion.attr('data-percent')),
        'color': divVersion.css("background-color"),
    };
}

function dataMonthCloseFields() {
    $('div.overlay_body').click(function() {
        dataMonthClose();
    });

    $('div.data_month div.close').click(function() {
        dataMonthClose();
    });
}

function dataMonthFill(date, versionsMajor, versionsMinor) {
    let versionsMajorHtml = getDataMonthVersionsHtml(versionsMajor, true);
    let versionsMinorHtml = hasMinor ? getDataMonthVersionsHtml(versionsMinor, false) : '';

    let divDataMonth = $('div.data_month');
    divDataMonth.find('div.date').html(date);

    let divMonth = divDataMonth.find('div.month');
    divMonth.html(versionsMajorHtml + versionsMinorHtml);
    divMonth.animate({scrollTop: divMonth.offset().top});

    if (hasMinor) {
        let aShowMinor = divDataMonth.find('div.show_major_minor a.show_minor');
        let aShowMajor = divDataMonth.find('div.show_major_minor a.show_major');
        if (isMajorShown) {
            aShowMajor.hide();
            aShowMinor.show();
        } else {
            aShowMinor.hide();
            aShowMajor.show();
        }
    }
}

function getDataMonthVersionsHtml(versions, isMajor) {
    versions.sort((a, b) => (a.percent < b.percent) ? 1 : -1)
    let maxPercent = (versions.length > 0) ? versions[0]['percent'] : 100;

    let divMonthHtml = '';
    let classMajorMinor = isMajor ? classDataMonthVersionMajor : classDataMonthVersionMinor;
    let styleDisplay = (isMajorShown && isMajor || !isMajorShown && !isMajor) ? 'block' : 'none';
    versions.forEach(function(version) {
        divMonthHtml = divMonthHtml + '\n'
            + '<div class="version ' + classMajorMinor + '" style="display: ' + styleDisplay + '">\n'
                + '<div class="name"><span class="name">' + version.name + '</span></div>\n'
                + '<div class="percent_visual" style="width: calc((100% - 200px) / ' + maxPercent + ' * ' + version.percent + '); background-color: ' + version.color + ';"></div>\n'
                + '<div class="percent_number">' + version.percent + '%</div>\n'
            + '</div>'
        ;
    });

    return divMonthHtml;
}


$(document).ready(function() {
    setMinor();
    majorMinorButton();
    dataMonthMajorMinorButton();
    //selectSubcategory();
    calcVersionDivWidth();
    dataMonthCloseFields();
    dataMonthOpenFields();
});

$(window).resize(function() {
    calcVersionDivWidth();
});