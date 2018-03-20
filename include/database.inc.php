<?php
$g_dbLink = null;
function dbInitConnect()
{
    global $g_dbLink;
    $g_dbLink = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    $error = mysqli_connect_error($g_dbLink);
    if ($error) {
        die('Unable to connect to DB');
    }

}

function dbQuery($query)
{
    global $g_dbLink;
    $result = mysqli_query($g_dbLink, $query);
    return ($result !== false);
}

function dbQuote($value)
{
    global $g_dbLink;
    return mysqli_real_escape_string($g_dbLink, $value);
}

function dbGetLastIncert()
{
    global $g_dbLink;
    return mysqli_incert_id($g_dbLink);
}

function dbQueryGetResult($query)
{
    global $g_dbLink;
    $data = [];
    $result = mysqli_query($g_dbLink, $query);
    if ($result) {
        while ($row = mysqli_fetch_assoc($result))
            array_push($data, $row);
        mysqli_free_result($result);
    }
    return $data;
}

function dbError()
{
    global $g_dbLink;
    return mysqli_error($g_dbLink);
}

function dbQueryResult($query)
{
    global $g_dbLink;
    $result = mysqli_query($g_dbLink, $query);
    return $result;
}


function addToBase($title, $description, $img, $link, $theme)
{
    if (!empty($title)) {
        $title = dbQuote($title);
        $description = dbQuote($description);
        $img = dbQuote($img);
        $link = dbQuote($link);
        $theme = dbQuote($theme);

        $query = "INSERT IGNORE INTO articles(title, description, img,  link, theme)
                                    VALUES
                                       ('$title' ,  
                                       '$description',
                                       '$img',
                                      '$link', 
                                      '$theme');";
        dbQuery($query);
    }
}


function addArticleInBase($header, $textPage, $lead, $link, $article_id)
{
    $header = dbQuote($header);
    $lead = dbQuote($lead);
    $link = dbQuote($link);
    $textPage = dbQuote($textPage);
    $article_id = dbQuote($article_id);
    $query = "INSERT IGNORE INTO article (header, text, lead, link, article_id)
                                    VALUES
                                       ('$header' ,  
                                       '$textPage',
                                       '$lead',  
                                        '$link', 
                                        '$article_id');";
    dbQuery($query);
}