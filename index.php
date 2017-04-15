<?php

require_once'Core/init.php';

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="preload" as="script" href="Includes/js/materialize.min.js">
    <link rel="preload" as="script" href="https://use.fontawesome.com/819d78ad52.js">
    <link rel="preload" as="script" href="Includes/js/jquery.min.js">
    <link rel="preload" as="image" href="Includes/images/code5.jpeg">
    <link rel="preload" as="image" href="Includes/images/code3.png">
    <link rel="preload" as="image" href="Includes/images/code2.png">
    <link rel="preload" as="image" href="Includes/images/code4.png">
    <link rel="preload" as="image" href="Includes/images/code1.png">
    <link rel="preload" as="style" href="http://fonts.googleapis.com/icon?family=Material+Icons">
    <title>
      Home
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="keywords" content="blog, technology, code, program, alorithms"/>
    <meta name="description" content="Publish your passions your way. Whether you'd like to share your knowledge, experiences or the latest tech news, create a unique and beautiful blog for free.">
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
    <style type="text/css">
        /* no added transitions for safari, mozilla, safari and other browsers*/
        .slider
        {
            z-index: -1;
        }
        nav
        {
            border-bottom: 1px white solid;
        }
        .brand-logo
        {
            display: inline-block;
            height: 100%;
        }
        .brand-logo > img {
            vertical-align: middle
        }
        nav ul .dropdown-button
        {
            width: 200px !important;
        }
        #secondary-content
        {
            position: relative;
            top: 100vh;
        }
        #write-blog
        {
            position: relative !important;
            top: -30% !important;
            z-index: 3 !important;
        }
        .ghost-button
        {
            display: inline-block !important;
            width: 200px !important;
            padding: 8px !important;
            color: #fff !important;
            border: 2px solid #fff !important;
            text-align: center !important;
            outline: none !important;
            text-decoration: none !important;
            text-shadow: 1px 1px 3px #000;
        }
        .ghost-button:hover, .ghost-button:active
        {
            background-color: #fff;
            color: #000;
            transition: background-color 0.3s ease-in, color 0.3s ease-in;
        }        
        .description
        {
            font-size: 12px;
        }
        a
        {
            text-decoration: none;
            color: none;
        }
        .pagination li.active
        {
            background-color: #42A5F5;
        }
        blockquote 
        {
            border-left: 5px solid #42A5F5;
        }
        .blockquote
        {
            font-size: 12px;
        }
        label
        {
            -webkit-transform: none !important; 
            transform: none !important; 
        }
        .loader-container
        {
            display: none;
        }
        .loader
        {
            border: 3px solid #f3f3f3; /* Light grey */
            border-top: 3px solid #42A5F5; /* Blue */
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 2s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        /*nav ul .navbar-menu
        {
            width: 167px;
        }*/
    </style>
</head>
<body>

    <?php

        include'header.php';

    ?>

    <div class="slider fullscreen" data-indicators="false">
        <ul class="slides">
            <li>
                <img src="Includes/images/code3.png">
            </li>
            <li>
                <img src="Includes/images/code1.png"> 
            </li>
            <li>
                <img src="Includes/images/code2.png">
            </li>
            <li>
                <img src="Includes/images/code4.png">
            </li>
            <li>
                <img src="Includes/images/code5.jpeg">
            </li>            
        </ul>
        <div id="write-blog" class="center-align">
            <a class="ghost-button z-depth-2" href="write_blog.php">WRITE A BLOG</a>
        </div>
    </div>
    <div id="secondary-content">
    <div class="row">        
        <form class="col s10 l6 offset-l3 offset-s1" onsubmit="return false;">
            <div class="input-field valign-wrapper">
                <!-- <i class='fa fa-search left valign' aria-hidden='true'></i> -->
                <input id="search" type="search" class="valign search" required placeholder="user: username | tags: tag1, tag2...">
                <label for="search"><i class="material-icons">search</i></label>
                <i class="material-icons close">close</i>
            </div>
                <input type="hidden" id="_token" value="<?php echo Token::generate(); ?>">
        </form>
    </div>
        <div class="row">
            <div class="col s12 l8">
                <div class="row">
                    <div class="col offset-s6">
                        <div class="loader-container">
                            <div class="loader"></div>
                        </div>
                    </div>
                </div>
                <h5 class="center-align">Recent Blogs</h5>
                <!-- <div class="content" id="content"> -->
                    <?php
                        $blogs = DB::getInstance()->sort('blogs', array('created_on', 'DESC'));
                        $num_blogs = $blogs->count();
                        $num_pages = ceil($num_blogs/5);
                        if($num_blogs)  // show blogs if there are any, otherwise show message 'No blogs'
                        {   
                            echo 
                            "<div class='primary-content'>
                                <div class='pagination_item_value' data-attribute='false'></div>";  // data-attribute = false => for default pagination,true => pagination for user, pagination for tags, pagination for title, pagination for name
                                    echo
                                    "<div class='content' id='content'>";
                            $blogs = $blogs->results();
                            $blogs = array_slice($blogs, 0, 5);
                            foreach($blogs as $blog)
                            {
                                $blog_tags = DB::getInstance()->get('blog_tags', array('blog_id', '=', $blog->id));
                                $blog_tags = $blog_tags->results();
                                $date=strtotime($blog->created_on); // changing the format of timestamp fetched from the database, converting it to milliseconds
                                echo 
                                    "<div class='row'>
                                        <div class='col s12 hide-on-med-and-up'>
                                            <div class='col s6'>
                                                <blockquote>".
                                                    date('M d', $date).' '.
                                                    date('Y', $date).
                                                "</blockquote>
                                            </div>
                                        </div>
                                        <div class='col s2 l2 hide-on-small-only'>
                                            <blockquote>".
                                                date('M', $date)."<br>".
                                                date('Y d', $date).
                                            "</blockquote>
                                        </div>
                                        <div class='col s12 l10'>
                                            <div class='row'>
                                                <div class='col s12 l10'>
                                                    <h5><a class='views' data-attribute='{$blog->views}' href='".Config::get('url/endpoint')."/view_blog.php?blog_id={$blog->id}'".">".ucfirst($blog->title)."</a></h5>
                                                    <h6>".ucfirst($blog->description)."</h6><br>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class='measure-count' data-attribute='{$blog->id}'>
                                                    <div class='col s2 l1'>
                                                        <i class='fa fa-eye fa-2x' aria-hidden='true' style='color:grey'></i>
                                                    </div>
                                                    <div class='col s1 l1'>
                                                        {$blog->views}
                                                    </div>
                                                    <div class='col s2 l1 offset-s1 offset-l1'>
                                                        <i class='fa fa-thumbs-up fa-2x' aria-hidden='true' style='color:grey'></i>
                                                    </div>
                                                    <div class='col s1 l1'>
                                                        {$blog->likes}
                                                    </div>
                                                    <div class='col s2 l1 offset-s1 offset-l1'>
                                                        <i class='fa fa-thumbs-down fa-2x' aria-hidden='true' style='color:grey'></i>
                                                    </div>
                                                    <div class='col s1 l1'>
                                                        {$blog->dislikes}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <div class='col s12'>";
                                                foreach($blog_tags as $blog_tag)
                                                {
                                                    echo "<div class='chip'>".$blog_tag->tags."</div>";
                                                }
                                                echo
                                                "</div>
                                            </div>
                                            <div class='divider'></div>
                                        </div>
                                    </div>";
                            }
                            echo 
                                "</div>
                                <div class='section center-align'>
                                    <ul class='pagination'>";
                                            for($x = 1; $x <= $num_pages; $x++)
                                            {
                                                if($x == 1)
                                                {
                                                    echo "<li class='waves-effect pagination active'><a href='#' class='blog-pagination'>".$x."</a></li>";
                                                }
                                                else
                                                {
                                                    echo "<li class='waves-effect pagination'><a href='#' class='blog-pagination'>".$x."</a></li>";
                                                }
                                            }   
                                    echo
                                    "</ul>
                                </div>
                            </div>";
                        }
                        else
                        {
                            echo "<div class='section center-align'>No blogs yet. <a href='write_blog.php'>Write the very first blog.</a></div>";
                        }
                    ?>
            </div>
            <div class="col s12 l4">
                <div class="section">
                    <h5 class="center-align">Recommended Blogs</h5>
                </div>
                <?php
                    $blogs = DB::getInstance()->sort('blogs', array('views', 'DESC'));
                    if($blogs->count())
                    {
                        if($blogs = $blogs->fetchRecords(5))
                        {
                            foreach($blogs as $blog)
                            {
                                $blog_tags = DB::getInstance()->get('blog_tags', array('blog_id', '=', $blog->id));
                                $blog_tags = $blog_tags->results();
                                $date=strtotime($blog->created_on); // changing the format of timestamp fetched from the database, converting it to milliseconds
                                echo 
                                "<div class='row'>
                                    <div class='col s12 hide-on-med-and-up'>
                                        <div class='col s6'>
                                            <blockquote>".
                                                date('M d', $date).' '.
                                                date('Y', $date).
                                            "</blockquote>
                                        </div>
                                    </div>
                                    <div class='col l2 hide-on-small-only'>
                                        <blockquote class='blockquote'>".
                                            date('M', $date)."<br>".
                                            date('Y d', $date).
                                        "</blockquote>
                                    </div>
                                    <div class='col s12 l10'>
                                        <div class='row hide-on-med-and-up'>
                                            <div class='col s12'>
                                                <h5><a class='views' data-attribute='{$blog->views}' href='".Config::get('url/endpoint')."/view_blog.php?blog_id={$blog->id}'".">".ucfirst($blog->title)."</a></h5>
                                                <h6>".ucfirst($blog->description)."</h6><br>
                                            </div>
                                        </div>
                                        <div class='hide-on-small-only'>
                                            <h6><a class='views' data-attribute='{$blog->views}' href='".Config::get('url/endpoint')."/view_blog.php?blog_id={$blog->id}'".">".ucfirst($blog->title)."</a></h6>
                                            <p class='description'>".ucfirst($blog->description)."</p><br>
                                        </div>
                                        <div class='row'>
                                            <div class='measure-count' data-attribute='{$blog->id}'>
                                                <div class='col s2 l1'>
                                                    <i class='fa fa-eye fa-lg' aria-hidden='true' style='color:grey'></i>
                                                </div>
                                                <div class='col s1 l1'>
                                                    {$blog->views}
                                                </div>
                                                <div class='col s2 l1 offset-s1 offset-l1'>
                                                    <i class='fa fa-thumbs-up fa-lg' aria-hidden='true' style='color:grey'></i>
                                                </div>
                                                <div class='col s1 l1'>
                                                    {$blog->likes}
                                                </div>
                                                <div class='col s2 l1 offset-s1 offset-l1'>
                                                    <i class='fa fa-thumbs-down fa-lg' aria-hidden='true' style='color:grey'></i>
                                                </div>
                                                <div class='col s1 l1'>
                                                    {$blog->dislikes}
                                                </div>
                                            </div>
                                        </div>";
                                        foreach($blog_tags as $blog_tag)
                                        {
                                            echo "<div class='chip'>".$blog_tag->tags."</div>";
                                        }
                                        echo
                                        "<div class='section hide-on-med-and-up'>
                                            <div class='divider'></div>
                                        </div>
                                    </div>
                                </div>";
                            }
                        }
                    }
                    else
                    {
                        echo 
                        "<h6 class='center-align'>No blogs yet</h6>";
                    }
                ?>
            </div>
        </div>
        <footer class="page-footer blue lighten-1">
            <div class="container">
                <div class="row">
                    <div class="col l6 s12">
                        <h5 class="white-text">TechSense</h5>
                        <p class="grey-text text-lighten-4">Publish your passions your way. Whether you'd like to share your knowledge, experiences or the latest tech news, create a unique and beautiful blog for free.</p>
                    </div>
                    <div class="col l4 offset-l2 s12">
                        <h5 class="white-text">View Our Other Projects</h5>
                        <ul>
                            <li><a class="grey-text text-lighten-3" href="http://www.silive.in" target="blank">silive.in</a></li>
                            <li><a class="grey-text text-lighten-3" href="#!" target="blank">Blood Donation Campaign 2017</a></li>
                            <li><a class="grey-text text-lighten-3" href="#!" target="blank">Table Tennis Tournament</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container center-align">
                    © 2017 Software Incubator
                </div>
            </div>
        </footer>
    </div>

    <script src="Includes/js/jquery.min.js"></script>
    <script src="https://use.fontawesome.com/819d78ad52.js"></script>
    <script type="text/javascript" src="Includes/js/materialize.min.js"></script>
    <script>
        if(typeof(Storage) !== "undefined")
        {
            console.log('not undefined');
            if(sessionStorage.getItem("flashMessage") !== null)
            {
                Materialize.toast(sessionStorage.getItem("flashMessage"), 5000 ,'green');
                sessionStorage.removeItem('flashMessage');
            }
        }
        $(document).ready(function(){
            $('.slider').slider();  // activate slider

            $(".dropdown-button").dropdown({hover: false});   // activate dropdown in the nav-bar

            $(".button-collapse").sideNav();

            $('.primary-content').on('click', '.blog-pagination', function(e){
                e.preventDefault();
                console.log('pagination');
                $('.active').removeClass('active');
                $(this).parent().addClass('active');
                var page_id = $(this).html();
                var query_type_status = $('.pagination_item_value').attr('data-attribute'); // variable query_type_status is to moderate the type of pagination, by default it's value will be 0
                if(query_type_status == 'false')
                {
                    var data = {page_id: page_id, query_type_status: query_type_status};
                }
                else
                {
                    var query = $('#search').val();
                    var data = {page_id: page_id, query_type_status: query_type_status, query: query};
                }
                console.log(query_type_status);
                console.log(data);
                // var _token = $('#_token').attr('data-attribute');

                $.ajax({
                    type: 'POST',
                    url: 'pagination_backend.php',
                    data: data,
                    // dataType: "json",
                    cache: false,
                    success: function(response)
                    {
                        var response = JSON.parse(response);
                        console.log(response);
                        if(response.error_status === true)
                        {
                            Materialize.toast(response.error, 5000, "red");
                        }
                        else
                        {
                            $('.content').html(response.content);
                        }
                    }
                });
            });

            $("#search").on("keypress", function(event) {
                if(event.which == 13)   // if the user hits enter
                {
                    var query = $('#search').val();     // fetch the query given by the user
                    var _token = $('#_token').val();
                    console.log("sending data");
                    $('.loader-container').show();
                    $.ajax({
                        type: "POST",
                        url: "search.php",
                        data: {query: query, _token: _token},
                        dataType: "json",
                        success: function(response)
                        {
                            // var response = JSON.parse(response);
                            $('.loader-container').hide();
                            console.log(response);
                            if(response.error_status === true)
                            {
                                if(response.error_code != 1)
                                {
                                    $('#_token').val(response._token);
                                    $('.primary-content').html(response.content);
                                }
                                else
                                {
                                    Materialize.toast(response.error, 5000, "red");
                                }
                            }
                            else
                            {
                                $('#_token').val(response._token);
                                $('.primary-content').html(response.content);
                            }
                        }
                    });
                }
            });

            $('.close').on('click', function() {
                $('.search').val('');
            });

            // $('.views').click(function(e){
            //     e.preventDefault();
            //     var blog_id = getBlogId(this);
            //     var _token = getToken();

            // });


            // $('.likes, .dislikes').click(function(e){
            //     e.preventDefault();
            //     var object = $(this);
                
            //     var blog_id = getBlogId(this);
            //     var _token = getToken();
            //     var count = $(this).attr('data-attribute');
            //     var className = getClassName(this);

            //     $.ajax({
            //         type: 'POST',
            //         url: 'blog_attributes.php',
            //         data: {blog_id: blog_id, _token: _token, field: className, count: count},
            //         cache: false,
            //         success: function(response)
            //         {
            //             var response = JSON.parse(response);
            //             console.log(response);
            //             $('#_token').attr('data-attribute', response._token);
            //             if(response.error_status)
            //             {
            //                 consol.log(response.error);
            //                 Materialize.toast(response.error, 5000, 'red');
            //                 return false;
            //             }
            //             else
            //             {
            //                 $(object).attr('data-attribute', response.count);
            //                 console.log(response.count);
            //                 console.log($(object).parent().next().text(response.count));
            //             }
            //         }
            //     });
            // });
   
            // function getToken()
            // {
            //     return $('#_token').attr('data-attribute');
            // } 

            // function getBlogId(object)
            // {
            //     return $(object).parent().parent().attr('data-attribute');
            // }

            // function getClassName(object)
            // {
            //     var className = $(object).attr('class');
            //     if(className === 'likes')
            //     {
            //         className = 'likes';
            //     }
            //     else if(className === 'dislikes')
            //     {
            //         className = 'dislikes';
            //     }

            //     return className;

            // }

        });
    </script>
</body>
</html>

