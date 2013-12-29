<?
include("session_start.php");
?>
<!DOCTYPE html>

<head>
<title>Saskatoon Police Report</title>

<link rel="stylesheet" type="text/css" href="spr.css">
</head>

<body>
    <div id="container">
        <?
            include("welcome_header.php");
        ?>
        <br clear="all">
        <div id="leftnav">
            <div class="menu_item"><span>About Us</span></div>
            <div class="menu_item"><span>News Archive</span></div>
            <div class="menu_item"><span>Inside Our Service</span></div>
            <div class="menu_item"><span>Programs &amp; Services</span></div>
            <div class="menu_item"><span>Recruiting</span></div>
            <div class="menu_item"><span>Online Reporting</span></div>
            <div class="menu_item"><span>Crime Mapping</span></div>
            <div class="menu_item"><span>Missing Persons</span></div>
            <div class="menu_item"><span>Wanted By Police</span></div>
            <div class="menu_item"><span>Can You Identify?</span></div>
            <div class="menu_item"><span>FAQ</span></div>
            <div class="menu_item"><span>New Headquarters</span></div>
            <div class="menu_item"><span>Social Media</span></div>
            <div class="menu_item"><span>Galleries</span></div>
            <div class="menu_item"><span>Downloads</span></div>
            <div class="menu_item"><span>Links</span></div>
        </div>
        <div id="content_noright">
            <h1>News Releases</h1>
        <?
        if(isset($_REQUEST['id']))
        {
            // Get post from database
            $postid = $_REQUEST['id'];
            $post_object = get_post_by_id($postid);
            // if it's approved
            if($post_object->is_approved())
            {
                echo $post_object->to_html_markup();
            }
            else if($user->is_approved_admin())
            {
                echo "<h3>Admin warning: This post is unapproved... 
                why not <a href='admin/post/approve.php?id=$postid'>approve it</a>?</h3>";
                echo $post_object->to_html_markup();
            }
            else
            {
                echo "<p>This article has not yet been approved 
                        by an admin, and can not be shown.</p>";
            }
            //      show it
            // else
            //      print "Not approved yet, how are you getting here?"
            //      if they are an admin while viewing
            //          show it anyway
            ?>
                <p>Admin functions</p>
        <?
        }
        else if(isset($_REQUEST['create']))
        {
            if(isset($_POST['releaseno']))
            {
                // Create the post!
                $release_number = $_POST['releaseno'];
                $prepared_by = $_POST['preparedby'];
                $subject = $_POST['subject'];
                $reportbody = $_POST['reportbody'];
                $occurrencedate = $_POST['occurrencedate'];
                $occurrencenumber = isset($_POST['occurrencenumber']) ? $_POST['occurrencenumber'] : 0;
                if($postid = add_post_to_db($user, $release_number, $prepared_by, $subject, 
                    $reportbody, $occurrencedate, $occurrencenumber))
                {
                    echo "<h2>Creating a new post</h2>";
                    echo "<p><a href='post.php?id=$postid'>Post successfully created!</a></p>";
                    echo "<p><a href='./'>Index</a></p>";
                }
            }
            else
            {
            ?>
            <h2>Creating a new post</h2>
            <form method="POST" action='post.php?create' class='post-form'>
                <label for='releaseno'>Release Number</label>
                <input type='number' required name='releaseno' id='releaseno' />
                <label for='preparedby'>Prepared By</label>
                <input type='text' required name='preparedby' id='preparedby' maxlength='100' size='50' placeholder='Your pen name, if you will'/>
                <label for='subject'>Subject</label>
                <input type='text' required name='subject' size='72' maxlength='150' id='subject'/>
                <label for='reportbody'>Body</label>
                <textarea rows="10" cols="72" name='reportbody' id='reportbody' placeholder='Put whatever you want in here' required></textarea>
                <label for='occurrencedate'>Occurrence Date</label>
                <input type='datetime-local' name='occurrencedate' id='occurrencedate'/>
                <label for='occurrencenumber'>Occurrence Number</label>
                <input type='number' name='occurrencenumber' id='occurrencenumber' placeholder='Not sure what this is for'/>
                <input type='submit'/>
            </form>
            <?
            }
        }
        else
        {
            // Get all posts
            $posts = get_all_posts();
            // For each post
            echo "<div class='content_item'>
            <br>";
            foreach($posts as $id=>$post)
            {
            ?>
            <div class="listed">
                <a href="post.php?id=<? echo $id; ?>"><? echo $post['subject']; ?></a>
                <div style="float:right;" class="date_small"><? echo date_format(date_create($post['occurrenceDate']), "F j, Y g:iA"); ?></div>
            </div>
            <?
            }
            echo "</div>";
        }
            ?>
            <br clear="all">
        </div>
        <div id="footer">
        This website is not affiliated whatsoever with the Saskatoon Police Service. I mean, come on, have you read the reports?<br>For more information, feel free to <a href="mailto:contact@saskatoonpolicereport.ca?Subject=I%20love%20your%20site" target="_top">Contact Us</a>.
        </div>
    </div>
    <div id="body_bg_top"></div>
    
    
</body>
</html>
