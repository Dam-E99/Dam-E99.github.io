<?php
// 1. Define your default "Pre-filled" values
$name = "Danny";
$img_src = "images/me_sitting_down.jpeg";
$img_alt = "Danny sitting down looking to the right";
$caption = "This photo was taken at a wedding held at a vineyard";
$bio = "How’s it going everyone, I am half way through my degree and I look forward to this class. Some interesting things about me are that I like to watch movies and anime, play video games mostly on PC, I am addicted to coffee and I have 3 dogs.";
$personal = "I am Mexican but was born in SC and moved to NC while I was a year old and grew up here my whole life. I have 4 older brothers; I am the youngest at 20 years old.";
$professional = "I have not had a professional job before although my mom has a small dog sitting company and I have helped out with that before.";
$academic = "My goal is Full Stack Programming AAS, and this is my second year.";
$computer = "Apple, MacBook Air laptop, MacOS, Primary location at home on my desk.";
$quote = "You have to be odd to be number one.";
$author = "Dr. Seuss";

// List of courses (flexible array)
$courses = [
    "ENG231 - American Literature l: This is a general education requirement course for my AAS.",
    "CSC154 - Software Development: This is a major requirement; this course will teach me about the fundamentals of software development.",
    "WEB115 - Web Markup and Scripting: A major requirement, this course will teach me about JavaScript",
    "WEB250 - Database Driven Websites: A major requirement, this course would be useful to learn dynamic websites.",
    "WEB215 - Adv Markup and Scripting: Major requirement, this will teach me to design internet applications and interactive web content."
];

// 2. If the form is submitted, overwrite the variables with POST data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $img_src = $_POST['img_src'];
    $img_alt = $_POST['img_alt'];
    $caption = $_POST['caption'];
    $bio = $_POST['bio'];
    $personal = $_POST['personal'];
    $professional = $_POST['professional'];
    $academic = $_POST['academic'];
    $computer = $_POST['computer'];
    $quote = $_POST['quote'];
    $author = $_POST['author'];
    $courses = $_POST['courses']; // This captures the array of courses
}
?>

<?php if ($_SERVER["REQUEST_METHOD"] != "POST"): ?>
    <!-- STATE A: THE INPUT FORM -->
    <h2>Edit Introduction</h2>
    <form method="post" action="index.php?page=introform">
        <label>Image URL:</label><br>
        <input type="text" name="img_src" value="<?php echo $img_src; ?>" ><br><br>

        <label>Image Alt Text:</label><br>
        <input type="text" name="img_alt" value="<?php echo $img_alt; ?>" ><br><br>

        <label>Caption:</label><br>
        <input type="text" name="caption" value="<?php echo $caption; ?>" ><br><br>

        <label>Bio:</label><br>
        <textarea name="bio" ><?php echo $bio; ?></textarea><br><br>

        <label>Personal Background:</label><br>
        <textarea name="personal" ><?php echo $personal; ?></textarea><br><br>

        <label>Professional Background:</label><br>
        <textarea name="professional" ><?php echo $professional; ?></textarea><br><br>

        <label>Academic Background:</label><br>
        <textarea name="academic" ><?php echo $academic; ?></textarea><br><br>

        <label>Primary Computer:</label><br>
        <input type="text" name="computer" value="<?php echo $computer; ?>" ><br><br>

        <label>Courses (One per line):</label><br>
        <?php foreach($courses as $c): ?>
            <input type="text" name="courses[]" value="<?php echo $c; ?>" ><br>
        <?php endforeach; ?>

        <br>
        <label>Quote:</label><br>
        <input type="text" name="quote" value="<?php echo $quote; ?>" ><br><br>

        <label>Author:</label><br>
        <input type="text" name="author" value="<?php echo $author; ?>" ><br><br>

        <button type="submit">Submit Introduction</button>
    </form>

<?php else: ?>
    <!-- STATE B: THE OUTPUT -->
        <h2>Introduction</h2>
        <figure>
            <img src="<?php echo $img_src; ?>" alt="<?php echo $img_alt; ?>">
            <figcaption><?php echo $caption; ?></figcaption>
        </figure>
        <p><?php echo $bio; ?></p>
        
        <ul class="intro_ul">
            <li><strong>Personal Background:</strong> <?php echo $personal; ?></li>
            <li><strong>Professional Background:</strong> <?php echo $professional; ?></li>
            <li><strong>Academic Background:</strong> <?php echo $academic; ?></li>
            <li><strong>Primary Computer:</strong> <?php echo $computer; ?></li>
            <li><strong>Courses I’m Taking, & Why:</strong>
                <ol>
                    <?php foreach($courses as $course): 
                        if(!empty(trim($course))): ?>
                            <li><?php echo $course; ?></li>
                        <?php endif; 
                    endforeach; ?>
                </ol>
            </li>
        </ul>
        <p class="text-center">“<?php echo $quote; ?>” </p>
        <p class="text-center">- <em><?php echo $author; ?></em></p>
        
        <p style="text-align:center;"><a href="index.php?page=introform">Edit Again</a></p>
<?php endif; ?>
