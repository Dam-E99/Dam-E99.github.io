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

    // Image Upload Logic
    if (!empty($_FILES['user_image']['name'])) {

        // 1. Check for PHP upload errors (like file too big)
        if ($_FILES['user_image']['error'] !== UPLOAD_ERR_OK) {
            // We echo the error so you can see it (Error 1 = Too Big)
            echo "<p style='color:red;'>Upload error code: " . $_FILES['user_image']['error'] . "</p>";
            $img_src = $_POST['existing_img'];
        } else {
            $target_dir = "images/";
            
            // 2. Ensure the directory exists
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            $file_name = basename($_FILES["user_image"]["name"]);
            $target_file = $target_dir . $file_name;
            $temp_file = $_FILES["user_image"]["tmp_name"];

            // 3. Move the file and update the path
            if (move_uploaded_file($temp_file, $target_file)) {
                $img_src = $target_file; 
            } else {
                $img_src = $_POST['existing_img'];
            }
        }
    } else {
        // No new file uploaded, keep the old one
        $img_src = $_POST['existing_img'];
    }

}
?>

<?php if ($_SERVER["REQUEST_METHOD"] != "POST"): ?>
    <!-- STATE A: THE INPUT FORM -->
    <h2>Edit Introduction</h2>

<form method="post" action="index.php?page=introform" enctype="multipart/form-data">

    <!-- Image Info -->
    <div class="field">
        <label>Upload New Image Or Use Default (Max Size: 2MB, Format: JPG, PNG, GIF.)</label>
        <input type="file" name="user_image" accept="image/*">
        <input type="hidden" name="existing_img" value="<?= htmlspecialchars($img_src) ?>">
    </div>

    <div class="row">
        <div class="field">
            <label>Alt Text</label>
            <input class="input-lg" type="text" name="img_alt" value="<?= htmlspecialchars($img_alt) ?>">
        </div>

        <div class="field">
            <label>Caption</label>
            <input class="input-lg" type="text" name="caption" value="<?= htmlspecialchars($caption) ?>">
        </div>
    </div>

    <!-- Bio -->
    <div class="field">
        <label>Bio</label>
        <textarea class="input-lg" name="bio"><?= htmlspecialchars($bio) ?></textarea>
    </div>

    <!-- Backgrounds -->
    <div class="row">
        <div class="field">
            <label>Personal</label>
            <textarea name="personal"><?= htmlspecialchars($personal) ?></textarea>
        </div>

        <div class="field">
            <label>Professional</label>
            <textarea name="professional"><?= htmlspecialchars($professional) ?></textarea>
        </div>
    </div>

    <div class="field">
        <label>Academic</label>
        <textarea name="academic"><?= htmlspecialchars($academic) ?></textarea>
    </div>

    <!-- Computer -->
    <div class="field">
        <label>Primary Computer</label>
        <input class="input-md" type="text" name="computer" value="<?= htmlspecialchars($computer) ?>">
    </div>

    <!-- Courses -->
    <div class="field">
        <label>Courses</label>

        <div id="courses-container">
            <?php foreach($courses as $c): ?>
                <div class="course-row">
                    <input class="input-lg" type="text" name="courses[]" value="<?= htmlspecialchars($c) ?>">
                    <button type="button" onclick="removeCourse(this)">✖</button>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="button" onclick="addCourse()">+ Add Course</button>
    </div>

    <!-- Quote -->
    <div class="row">
        <div class="field">
            <label>Quote</label>
            <input class="input-md" type="text" name="quote" value="<?= htmlspecialchars($quote) ?>">
        </div>

        <div class="field">
            <label>Author</label>
            <input class="input-sm" type="text" name="author" value="<?= htmlspecialchars($author) ?>">
        </div>
    </div>

    <!-- Submit -->
    <button type="submit">Submit Introduction</button>

</form>

<?php else: ?>
    <!-- STATE B: THE OUTPUT -->
        <h2>Introduction</h2>
        <figure>
            <img src="<?= htmlspecialchars($img_src) ?>" alt="<?= htmlspecialchars($img_alt) ?>">
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
        <?php if (!empty(trim($quote))): ?>
            <p class="text-center">“<?= htmlspecialchars($quote) ?>” </p>
            <?php if (!empty(trim($author))): ?>
                <p class="text-center">- <em><?= htmlspecialchars($author) ?></em></p>
            <?php endif; ?>
        <?php endif; ?>

        
        <p style="text-align:center;"><a href="index.php?page=introform">Edit Again</a></p>
<?php endif; ?>

<script>
function addCourse() {
    const container = document.getElementById("courses-container");

    const div = document.createElement("div");
    div.classList.add("course-row");

    div.innerHTML = `
        <input class="input-lg" type="text" name="courses[]" placeholder="New course...">
        <button type="button" onclick="removeCourse(this)">✖</button>
    `;

    container.appendChild(div);
}

function removeCourse(button) {
    button.parentElement.remove();
}
</script>