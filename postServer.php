<?php
        header('Content-type: text/html; charset=utf-8');
	    ini_set('default_charset', 'utf-8');
        require "connect.php";
        $section = $conn->real_escape_string($_GET["section"]);
        $amount =  $conn->real_escape_string($_GET["amount"]);
//offset
        if($section == "nation"){
            $section = "Nation & World";
        }
        $result = $conn->query("SELECT * FROM articles WHERE section = \"{$section}\" ORDER BY Date DESC LIMIT 9 OFFSET " . ($amount - 9));
        //ORDER BY DATE
        //AMOUNT!!!
        
        $out = "";
        while($post = $result->fetch_assoc()){
            //$out .= ($post["Title"] . "\n");
            
            
            $date = date_create($post["Date"]);
            $dateString = date_format($date,"F d, Y");
            
            $placeholderLink = $post["Section"];
            
            if($section === "Nation & World"){
                $placeholderLink = "News";
            }
            
            $link = "pictures/placeholders/{$placeholderLink}.jpg";
            if($post["Image"] == 1){
                $link = "pictures/articles/" . $post["ID"] . ".jpg";
                if(!file_exists($link)){
                    $link = "pictures/placeholders/{$placeholderLink}.jpg";
                }
            };
            
            $author = $post["Author"];
            $title = $post["Title"];
            //plcaehodler imaegeeee?! 
            $out .= "<article class=\"post_type_4\">
								<div class=\"feature\">
									<div class=\"image\">
										<a href=\"article.php?id={$post["ID"]}\"><img src=\"{$link}\"><span class=\"hover\"><h2 class =\"pic_text\">{$author}</h2></span></a>     
									</div>
								</div>
								
								<div class=\"content\">
									<div class=\"info\">
										<div class=\"tags {$post["Section"]}\">{$post["Section"]}</div>
										<div class=\"date\">{$dateString}</div>
									</div>
									
									<div class=\"title\">
										<a href=\"article.php?id={$post["ID"]}\">{$title}</a>
									</div>
									
									<div class=\"line_1\"></div>
								</div>
							</article>";
            
                            
        }
        echo $out;
        $conn->close();
?>							