<?php
function getLinkContentPM($link, $article_id, $theme)
{
    if (!empty($link)) {

        $curl = curl_init($link); // Инициализируем curl по указанному адресу
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // Записать http ответ в переменную, а не выводить в буфер
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // Этот параметр нужен для работы HTTPS
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // Этот параметр нужен для работы HTTPS
        $page = curl_exec($curl);

        $document = phpQuery::newDocument($page);

        $header = pq($document)->find('div.wrapper');
        $header = pq($header)->find('header.article_header');
        $header = pq($header)->find('h1');
        $header = pq($header)->text();

        $textPage = pq($document)->find('div.text-page');
        $textPage = pq($textPage)->find('p');

        $imgs = pq($textPage)->find('span.img');
        $imgs = pq($imgs)->find('img');
        $i = 0;
        foreach ($imgs as $img) {

            $img = pq($img)->attr('src');
            $src = $img;

            if (!empty($img)) {
                copy($img, "../content/img/articleImage" . $i . 'apm' . $theme . $article_id . ".jpg");
                $newlink = ("content/img/articleImage" . $i . 'apm'. $theme . $article_id . ".jpg");
                echo $article_id;
                $i = $i + 1;
                $textPage = str_replace($src, $newlink, $textPage);
            }
        }
        $lead = pq($document)->find('div.lead');
        $lead = pq($lead)->text();
        addArticleInBase($header, $textPage, $lead, $link, $article_id);
    }

}

function getLinkContentNS($link, $article_id, $theme)
{
    if (!empty($link)) {

        $curl = curl_init($link); // Инициализируем curl по указанному адресу
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // Записать http ответ в переменную, а не выводить в буфер
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // Этот параметр нужен для работы HTTPS
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // Этот параметр нужен для работы HTTPS
        $page = curl_exec($curl);

        $document = phpQuery::newDocument($page);

        $header = pq($document)->find('div.pane-content');
        $header = pq($header)->find('h1');
        $header = pq($header)->text();


        $textPage = pq($document)->find('div.views-field');
        $textPage = pq($textPage)->find('p');
        $imgs = pq($textPage)->find('img');

        $i = 0;

        foreach ($imgs as $img) {
            $src = $img;
            $src = pq($src)->attr('src');
            $img = formatImgsNs($img);

            copy($img, "../content/img/articleImageNs" . $i . 'ans' . $theme . $article_id . ".jpg");
            $newlink = ("content/img/articleImageNs" . $i . 'ans' . $theme . $article_id . ".jpg");
            $i = $i + 1;
            $textPage = str_replace($src, $newlink, $textPage);

        }

        $lead = '';
        addArticleInBase($header, $textPage, $lead, $link, $article_id);
    }
}

function strExploid($img)
{
    if (!empty($img)) {

        $img = explode('(', $img);//обрезать строку
        $img = $img[1];
        $img = explode('?', $img);
        $img = $img[0];
    } else {
        $img = '';
    }
    return $img;
}

function formatImgsNs($img)
{

    $img = pq($img)->attr('src');

    $imgPat = (substr($img, 0, 15));
    switch ($imgPat) {
        case ('/sites/default/'):
            $img = 'https://naked-science.ru' . $img;
            break;
        case ('http://naked-sc'):
            break;
        default:
            $img = '';
            break;


    }
    return $img;
}