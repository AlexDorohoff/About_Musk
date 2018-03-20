<?php

function startParse()
{
    ///запуск по cron online

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('max_execution_time', '10000');

    parseNS('https://naked-science.ru/tags/ilon-mask', 'elon');
    parsePM('https://www.popmech.ru/search/?query=%D0%B8%D0%BB%D0%BE%D0%BD+%D0%BC%D0%B0%D1%81%D0%BA', 'elon');
    parseNS('https://naked-science.ru/tags/tesla', 'tesla');
    parseNS('https://naked-science.ru/search/node/boring%20company', 'boring');;
    parsePM('https://www.popmech.ru/search/?query=Boring+Company', 'boring ');
    parseNS('https://naked-science.ru/search/node/spacex', 'spasex');;
    parsePM('https://www.popmech.ru/search/?query=spacex', 'spasex');


}

function parsePM($link, $theme)
{
    $curl = curl_init($link); // Инициализируем curl по указанному адресу
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // Записать http ответ в переменную, а не выводить в буфер
    curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0); // Этот параметр нужен для работы HTTPS
    curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 0); // Этот параметр нужен для работы HTTPS
    $page = curl_exec($curl);

    $document = phpQuery::newDocument($page);

    $elements = $document->find('a.article-listed');
    $i = 0;
    foreach ($elements as $element) {
        addToParsePM($element, $i, $theme);
        $i++;
    };
}

function addToParsePM($element, $i, $theme)
{
    $title = pq($element)->find('h2');
    $title = pq($title)->text();

    $description = pq($element)->find('p.preview-text');
    $description = pq($description)->text();

    $pic = pq($element)->find('img.preview-image');
    $img = $pic->attr("src");

    copy($img, "../content/img/image" . $i . $theme . $theme . ".jpg");
    $img = "content/img/image" . $i . $theme . $theme . ".jpg";

    $link = pq($element)->attr('href');
    $link = 'https://www.popmech.ru' . $link;

    $article_id = $i;
    addToBase($title, $description, $img, $link, $theme);
    getLinkContentPM($link, $article_id, $theme);

}

function parseNS($link, $theme)
{

    $curl = curl_init($link); // Инициализируем curl по указанному адресу
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // Записать http ответ в переменную, а не выводить в буфер
    curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0); // Этот параметр нужен для работы HTTPS
    curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 0); // Этот параметр нужен для работы HTTPS
    $page = curl_exec($curl);

    $i = 0;

    $document = phpQuery::newDocument($page);

    $content = $document->find('section#content');
    $contents = pq($content)->find('div.view-content');
    $elements = pq($contents)->find('div.views-row');

    foreach ($elements as $element) {
        addToParseNs($element, $i, $theme);
        $i++;
    };
}

function addToParseNs($element, $i, $theme)

{
    $title = pq($element)->find('div.views-field-title');
    $title = pq($title)->text();

    $description = pq($element)->find('div.field-content');
    $description = pq($description)->text();

    $pic = pq($element)->find('a');
    $img = $pic->attr("style");
    $img = strExploid($img);
//вынести в функцию
    if (!empty($img)) {    ///копируем картинку
        copy($img, "../content/img/NSimage". $theme . $i . ".png");
    }

    $link = pq($pic)->attr('href');
    $link = 'https://naked-science.ru' . $link;

    if (substr($link, 0, 25) == 'https://naked-science.ru/') {

        $img = "content/img/NSimage" . $theme . $i . ".png";
        $article_id = $i;
        addToBase($title, $description, $img, $link, $theme);
        getLinkContentNS($link, $article_id, $theme);
    };
}
