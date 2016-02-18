<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Frontend zadatak</title>


    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <link href="css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="css/jquery.sidr.light.css">


</head>
<body>

<div style="display: none;" class="blurDiv"></div>


<div class="row menu">
    <div class="col0_5lg col_lg_offSet_0_5 col_md_offSet_0_5 col_sm_offSet_0_5 col_xs_offSet_0_5">
        <a id="left-menu" href="#">
            <img class="filterImg" src="img/filter.png" alt="" />
        </a>
    </div>
    <div class="col0_5lg col_lg_offSet_11 col_md_offSet_11 col_sm_offSet_11 col_xs_offSet_11 navIcon">
        <a id="right-menu" href="#">
            <img class="menuImg" src="img/menu.png" alt="" />
        </a>
    </div>
</div>

<div class="row">
    <div class="col4lg col4md col5sm col8xs header">
        <img class="img-responsive" src="img/headerH1.png" alt=""/>
    </div>
</div>


<div id="content" class="row">

</div>


<div id="left">
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <ul id="selectLanguage">
        </ul>
    </form>
</div>



<div class="row">
    <div class="modal">
        <div class="row">
            <div class="col4lg col4md col5sm col8xs header">
                <img class="img-responsive" src="img/headerH1.png" alt=""/>
            </div>
        </div>
        <div class="row">
            <div class="col0_5lg col_lg_offSet_7 col_md_offSet_8 col_sm_offSet_11 col_xs_offSet_12 navIcon">
                <a id="right-menu" href="#">
                    <img class="closePop_up" src="img/X.png" alt="" />
                </a>
            </div>
        </div>


            <iframe class="playerVideo" src="" frameborder="0";>
            </iframe>

    </div>
</div>



<div id="right">
    <ul id="games">
    </ul>
</div>


<div class="row rowLoadMore">
    <div class="col0_5lg col0_5md col0_5sm col2xs loadMore"><label>LOAD MORE</label></div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


<!-- Sidr plugin -->
<script src="js/jquery.sidr.js"></script>


<script>
    $(document).ready(function(){

        var onlyOnce = 0;


        //pop_up modal
        $('.modal').hide();


        $('.modal').css("height",$(window).height());


        $('#left-menu').sidr({
            name: 'sidr-left',
            side: 'left',
            source: "#left"
        });

        $('#right-menu').sidr({
            name: 'sidr-right',
            side: 'right',
            source: "#right"
        });

        //close pop_up and stop video setting scr to ''
        $('.closePop_up').on('click',function() {
            $('.modal').hide();
            $('.playerVideo').attr('src', '');
            onlyOnce=0;
        });


        //change filter img to X
        $('.filterImg').click(function() {
            var clicks = $(this).data('clicks');
            if (clicks) {
                $(this).attr('src', 'img/filter.png');
                setTimeout(function(){$('.blurDiv').css("display", "none")},210);
            } else {
                $(this).attr('src', 'img/X.png');
                setTimeout(function(){$('.blurDiv').css("display", "block")},260);
            }
            $(this).data("clicks", !clicks);
        });

        //change img menu src to X
        $('.menuImg').click(function() {
            var clicks = $(this).data('clicks');
            if (clicks) {
                $(this).attr('src', 'img/menu.png');
                setTimeout(function(){$('.blurDiv').css("display", "none")},200);
            } else {
                $(this).attr('src', 'img/X.png');
                setTimeout(function(){$('.blurDiv').css("display", "block")},250);
            }
            $(this).data("clicks", !clicks);
        });



        var streams = 'https://api.twitch.tv/kraken/streams';
        var streamInfo = {};
        var counter =0;

        //ne želim da mi prolazi onoliko puta koliko imam streamova
        var onlyOnce = 0;

        var onlyCount =0;

        var languege = [];
        var games = [];

        var gameSearchName = '';
        var languageSearch = [];

        //var for language sidebar
        var lng ='';

        var promjenaFiltra = false;

        //pomocni array radi slanja jezika
        //za vise jezika potrebno je novi npr.url https://api.twitch.tv/kraken/streams?language=XXXX
        var ponArrayLanguage =[];

        var countAppends =0;




        //prvi puta prima streams, svaki sljedeći novi url
        getStreams(streams,'');




        function getStreams(streamsSearch,language){


            $.getJSON(streamsSearch, function (data) {

                $.each(data,function(key, value){
                    if(key=='streams')
                        $.each(value,function(key2, value2){
                            $.each(value2,function( key3, value3 ){

                                if(key3=="channel"){
                                    $.each(value3, function(key4, value4){

                                        streamInfo[key4] = value4;


                                        //Languages and games fill array from first stream url
                                        if(streamsSearch == streams) {

                                            //Push and append if value4 is not in array language
                                            //language fill
                                            if (key4 == "language") {
                                                if (jQuery.inArray(value4, languege) == -1) {
                                                    //if the element is not in the array
                                                    languege.push(value4);
                                                    switch (value4) {
                                                        case 'en':
                                                            lng = "ENGLISH";
                                                            break;
                                                        case 'de':
                                                            lng = "GERMAN";
                                                            break;
                                                        case 'hr':
                                                            lng = "CROATIAN";
                                                            break;
                                                        case 'it':
                                                            lng = "ITALIAN";
                                                            break;
                                                        case 'fr':
                                                            lng = "FRENCH";
                                                            break;
                                                        case 'ru':
                                                            lng = "RUSSIAN";
                                                            break;
                                                        case 'pl':
                                                            lng = "POLISH";
                                                            break;
                                                        case 'es':
                                                            lng = "SPANISH";
                                                            break;
                                                        case 'tr':
                                                            lng = "TURKISH";
                                                            break;
                                                        case 'nl':
                                                            lng = "NETHERLANDS";
                                                            break;
                                                        case 'pt':
                                                            lng = "PORTUGUESE";
                                                            break;
                                                        case 'pt-br':
                                                            lng = "PORTUGUESE &#40;BRAZIL)";
                                                            break;
                                                        case 'zh-tw':
                                                            lng = "CHINESE &#40;TAIWAN)";
                                                            break;
                                                        default:
                                                            lng = value4;
                                                            break;
                                                    }
                                                    $('#sidr-id-selectLanguage').append(
                                                        '<li><label for=\"' + lng + '\">' + lng + '</label><input type=\"checkbox\" name=\"language[]\" id=\"' + lng + '\" value=\"' + value4 + '\"/></li>'
                                                    );
                                                }
                                            }
                                            //end language fill


                                            //Push and append if value4 is not in array games
                                            //games fill
                                            if (key4 == "game") {
                                                if (jQuery.inArray(value4, games) == -1) {
                                                    // the element is not in the array
                                                    games.push(value4);

                                                    $('#sidr-id-games').append(
                                                        //'<li><label class="sidebar sidebarGames" id="'+ value4 +'">' + value4 + '</label></li>'
                                                        '<li><input class="gameCheck" type="checkbox" id="' + value4 + '" name="game[]" value="' + value4 + '"/><label for="' + value4 + '" class="sidebarGames">' + value4 + '</label></li>'
                                                        //'<li><input type="radio" id="' + value4 + '" name="game" value="' + value4 + '"/><label for="'+ value4 +'" class="sidebarGames">'+ value4 +'</label></li>'
                                                    );

                                                }
                                            }
                                        }

                                    });




                                    //Append in content
                                    if(countAppends<25) {
                                        if (language == '') {
                                            append();
                                        } else if (language == 'drugiPuta' && gameSearchName == '') {
                                            //provjeri da li igra postoji u pocetnoj trazilici (pocetnih 25 streamova)
                                            if (jQuery.inArray(streamInfo['game'], games) != -1) {
                                                append();
                                                countAppends++;
                                            }
                                        }else if(language == 'drugiPuta' && gameSearchName != ''){
                                            if (streamInfo['game'] == gameSearchName) {
                                                append();
                                                countAppends++;
                                            }
                                        }
                                    }
                                    //End Append

                                }

                            });



                            //left side filter game
                            $('.gameCheck').on('change', function() {
                                $('.gameCheck').not(this).prop('checked', false);

                                gameSearchName = $(this).attr('id');
                                promjenaFiltra=true;
                                onlyOnce=0;
                            });
                            //end right side filter game




                            //left side filter language
                            $('input[name="language[]"]').click(function(){

                                var string =  ""+$(this).val()+"";

                                if($(this).prop('checked')){
                                    languageSearch = languageSearch.filter(function(elem){
                                        return elem != string;
                                    });
                                    languageSearch.unshift($(this).val());
                                }else{
                                    //vrati array bez tog elementa
                                    languageSearch = languageSearch.filter(function(elem){
                                        return elem != string;
                                    });
                                }
                                onlyOnce=0;
                                promjenaFiltra=true;

                            });
                            //end left side filter language





                            $('.loadMore').click(function() {


                                if($('[name="game[]"]:checked').length ==0){
                                    gameSearchName='';
                                }

                                //alert(gameSearchName+"----"+promjenaFiltra);

                                if (promjenaFiltra == true) {

                                    //alert("proslo");
                                    ponArrayLanguage = languageSearch;

                                    if (gameSearchName == '' && languageSearch == 0) {
                                        $("#content").html('');
                                        getStreams(streams, '');
                                    }else if (languageSearch == 0) {

                                        if (onlyOnce == 0) {

                                            $("#content").html('');
                                            getStreams('https://api.twitch.tv/kraken/streams?game=' + gameSearchName + '&limit=25', '');

                                        }

                                    } else if (gameSearchName == '' && languageSearch != 0) {

                                        $("#content").html('');

                                        if (onlyOnce == 0) {

                                            //append
                                            $.each(ponArrayLanguage, function (key, val) {

                                                getStreams('https://api.twitch.tv/kraken/streams?language=' + val, 'drugiPuta');
                                                //console.log(limitNew+ '  ---   '+checkedLength);

                                                //brisanje svakog jezika nakon appenda
                                                ponArrayLanguage = ponArrayLanguage.filter(function (elem) {
                                                    return elem != language;
                                                });

                                                //alert(val);
                                            });

                                            countAppends=0;

                                        }

                                    }else if(gameSearchName != '' && languageSearch != 0){

                                        $("#content").html('');

                                        if (onlyOnce == 0) {

                                            //append
                                            $.each(ponArrayLanguage, function (key, val) {

                                                getStreams('https://api.twitch.tv/kraken/streams?language=' + val, 'drugiPuta');

                                                //brisanje svakog jezika nakon appenda
                                                ponArrayLanguage = ponArrayLanguage.filter(function (elem) {
                                                    return elem != language;
                                                });

                                                //alert(val);
                                            });

                                            countAppends=0;

                                        }

                                    }

                                    onlyOnce = onlyOnce - 1111;
                                    promjenaFiltra=false;

                                }
                            });




                            //Open video stream
                            $('.streamVideo').on('click',function() {
                                var src = 'http://player.twitch.tv/?channel=' + $(this).attr('id');
                                if(onlyOnce==0)
                                    $('.playerVideo').attr('src', src);
                                onlyOnce=onlyOnce-1111;
                                $('.modal').show();
                            });

                        });

                    //End first loop
                });


                //End Json
            });




        }









        // FUNCTION APPEND CONTENT//
        function append(){

            // Date format FEB 11, 2016
            var month =  streamInfo['updated_at'].substr(5,2);
            switch (month){
                case '01':
                    month = 'JAN ';
                    break;
                case '02':
                    month = 'FEB ';
                    break;
                case '03':
                    month = 'MAR ';
                    break;
                case '04':
                    month = 'APR ';
                    break;
                case '05':
                    month = 'MAY ';
                    break;
                case '06':
                    month = 'JUN ';
                    break;
                case '07':
                    month = 'JUL ';
                    break;
                case '08':
                    month = 'AUG ';
                    break;
                case '09':
                    month = 'SEP ';
                    break;
                case '10':
                    month = 'OCT,';
                    break;
                case '11':
                    month = 'NOV,';
                    break;
                case '12':
                    month = 'DEC,';
                    break;
                default :
                    month = '';
            }
            var date = month + streamInfo['updated_at'].substr(8,2)+ ', ' +streamInfo['updated_at'].substr(0,4);
            //End Date format


            //APPEND CONTENT//
            $("#content").append(
                '<div id="' + streamInfo['name'] + '" class="streamVideo col3lg col3md col5sm col8xs col8xs col_lg_offSet_1 col_md_offSet_1 col_sm_offSet_1 stream '+ streamInfo['language'] +'">' +
                '<div style="background-image: url(' + streamInfo['profile_banner'] + ');" class="row profilBanner">' +
                '<div class="profilBannerTop">' +
                '<div class="row profilBannerContent">' +
                '<div class="col3lg col2md col1sm col2xs">' +
                '<img class="img-responsive" src=\"' + streamInfo['logo'] + '\"  alt=""/>' +
                '</div>' +
                '<div class="col6lg col5md col5sm col4xs">' +
                '<h4>' + streamInfo['display_name'] + '</h4>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="row videoBanner">' +
                '<img src=\"' + streamInfo['video_banner'] + '\" alt=\"\">' +
                '</div>' +
                '<div class="row game">' +
                '<div style="font-size: ' + '12px;' + '" class="row gameName">' +
                '<h3>' + streamInfo['game'] + '</h3>' +
                '</div>' +
                '<div class="row gameViewers">' +
                '<div class="col8lg">' +
                '<div class="col1lg">' +
                '<label><img src="img/viewers.png" alt=""></label>' +
                '</div>' +
                '<div class="col4lg gameViews">' +
                '<label>' + streamInfo['views'] + '</label>' +
                '</div>' +
                '<div class="col6lg gameViewersDate">' +
                '<label class="dot">&#183;</label><label>' + date + '</label>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>'
            );

            counter++;
        }
        //END FUNCTION//


    });
</script>
</body>
</html>