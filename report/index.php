<?php 
 if(!defined('APP_STARTED')){
  exit;
 }
?>

<div class="page-section reflective-report">
  <article class="intro">
  <h1>Reflective Reporting: Venkata</h1>
  <p>Here is where we reflect on the learning process for the project:</p>
  <ul>
    <li><strong> What was good: </strong> 
   I get to learn the backend php new programming language that I never taught would learn , since I am always focussed on javascript.
  </li>
    <li> <strong> What was bad:</strong> The struggle of learning a new language again </li>
    <li> <strong> What was fun:</strong> The fun watching how php could make possible both HTML and programming language in same file unlike JS </li>
    <li> <strong> What was boring:</strong> Again initial slow stages of learning a new language   </li>
    <li><strong>What was my contribution :</strong>  My main contributions to the project included implementing the product listing page with filtering  functionality, improving the user interface with consistent styling, and developing the comment system. other things like navbar and things from the first project and login systems

The filtering system allows users to search listings by keywords, price range, and number of likes. I also implemented sorting options such as newest, oldest, and most liked.

Additionally, I worked on the listing page where users can mark interest and leave comments. These comments are stored in the database and displayed both on the listing page and on the profile page of the listing owner.</li>
    <li> <strong> What took too long to understand:</strong>
       One of the main challenges I faced was handling file uploads and server permissions. Initially, images could not be uploaded due to permission errors on the server. This required understanding how file permissions work and how PHP interacts with the filesystem.
Another challenge was working with GitHub collaboratively. There were situations where changes caused conflicts, and I had to learn how to pull, merge, and resolve differences between versions.

I also encountered issues with SQL queries and debugging errors such as incorrect column names and missing session variables. These problems helped me better understand database structure and backend debugging.
    </li>
    <li>
    For the comments/chat functionality, I created a separate "comments" table in the database. Each comment is linked to both a user and a listing using foreign keys. This allows users to leave comments on listings, and listing owners can view all received comments on their profile page.

Replies are handled by posting additional comments on the same listing, which creates a simple conversation structure similar to older social platforms.

While the current implementation fulfills the basic requirements, a more advanced solution could include a conversation_id to group messages into structured chat threads.
  
    </li>
  
    <li> <strong> How the course could have been better for me: </strong>  If i had previous experience of working with PHP</li>
    <li> <strong> Conclusion: </strong> Its good learning project to gain valuable experience to understand different parts of web development and working together. To do a collaborative work  </li>
  </ul>

  </article>
  <article class="intro">
  <h1>Reflektiv rapport: Erik</h1>
  
  <p>Jag är bekant med PHP från tidigare, så jag hade inga större svårigheter med att förstå mina delar. Jag fick i alla fall bekanta mig med vissa nya PHP-funktioner som jag inte hade behövt använda innan (t.ex. "mail()"-funktionen), så det blev i alla fall inte tråkigt eller ointressant för mig.</p> <br>
  
  <p>I och med att det angivna målet i projekt 1 inte var att ännu få ihop en funktionellt komplett webbsida ledde till att jag personligen var omotiverad att arbeta hårt på projektet, eftersom det som jag anser vara roligast – att få se det fullständiga pusslet läggas färdigt, så att säga – kommer först i projekt 2. Jag lade själv inte mycket fokus på det visuella. Jag inser att jag kunde ha varit mer aktiv och tagit initiativet att kommunicera mer med mitt projektpar, vilket jag lovar att göra för projekt 2.</p><br>

  <p>Eftersom den här delen av kursen var mer inriktad på grunderna i PHP så tror jag att jag personligen inte ännu kände mig lika utmanad som jag ville med mina nuvarande erfarenheter i språket. Jag kunde visst ha gett mig själv större utmaningar inom projekts ramar, vilket förstås var tillåtet, men det gjorde jag inte vilket var mitt eget fel.</p>
  </ul>
  
  </article>
</div>