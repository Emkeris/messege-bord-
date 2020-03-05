<?php 
    @include 'includes/config.php';
    @include 'includes/classes/Post.php';
    @include 'includes/handlers/process.php';

    // finding total number of messages
    $sql = mysqli_query($con, "SELECT * FROM messages") or die(mysqli_errno($con));
    $resultNumber = mysqli_num_rows($sql);
    $resultPerPage = 3;

    // number of total pages = total number of messages / Results per gage;
    $numberOfPages = ceil($resultNumber/$resultPerPage);

    // determin whitch page user are in
    if(!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    // determile sql LIMIT starting number of results on display page; 
    $thisPageFirstResult = ($page-1)*$resultPerPage;

    // retrieve selected results from database
    $resultQuery = mysqli_query($con, "SELECT * FROM messages LIMIT $thisPageFirstResult, $resultPerPage") or die(mysqli_error($con)); 

    // age funcion
    $age = "";
    function getAge($birthDate) {
        $date = new DateTime($birthDate);
        $now = new DateTime();
        $age = $now->diff($date);
        return $age->y;
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Žinutės</title>
        <link rel="stylesheet" media="screen" type="text/css" href="css/screen.css" />
    </head>
    <body>
        <div id="wrapper">
            <h1>Jūsų žinutės</h1>
            <form method="POST" action="includes/handlers/process.php">
                <p class="err">
                    <label for="fullname">Vardas, pavardė *</label><br/>
                    <input id="fullname" type="text" name="fullname" value="" required/>
                </p>
                <p>
                    <label for="birthdate">Gimimo data *</label><br/>
                    <input type="date" id="birthdate" type="text" name="birthdate" value="" required/>
                </p>
                <p>
                    <label for="email">El.pašto adresas</label><br/>
                    <input id="email" type="text" name="email" value="" name="email"/>
                </p>
                <p class="err">
                    <label for="message">Jūsų žinutė *</label><br/>
                    <textarea id="message" name="message" required></textarea>
                </p>
                <p>
                    <span>* - privalomi laukai</span>
                    <input type="submit" value="Skelbti" name="skelbtiBtn"/>
                    <img src="img/ajax-loader.gif" alt="" />
                </p>
            </form>

            <!-- Outputed messages -->
            <ul>
                <?php while ($row = mysqli_fetch_assoc($resultQuery)) : ?>
                    <?php if(empty($row['email'])) : ?>
                        <li>
                            <span><?php echo $row['msgDate'] ?></span> <?php echo $row['fullName'] ?>, <?php echo getAge($row['birthDate']) ?> m.<br/>
                            <?php echo $row['msg'] ?>
                        </li>
                    <?php else : ?>
                        <li>
                            <span><?php echo $row['msgDate'] ?></span> <a href="mailto:<?php echo $row['email'] ?>"><?php echo $row['fullName'] ?></a>, <?php echo getAge($row['birthDate']) ?> m.<br/>
                            <?php echo $row['msg'] ?>
                        </li>
                    <?php endif ; ?>

                <?php endwhile;?>
            </ul>
            <p id="pages">
                <a href="#" title="atgal">atgal</a>
                <?php for($page=1; $page<= $numberOfPages; $page++) {
                echo  "<a href='index.php?page=$page' title='$page'>$page</a>";
                    }
                ?>
                <a href="#" title="toliau">toliau</a>
            </p>
        </div>
    </body>
    </html>
