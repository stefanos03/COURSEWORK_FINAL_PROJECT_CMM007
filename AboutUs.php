<?php
include("myPhpFunctionalities/Configuration.php");
include("header.php");
?>
<header>
    <nav class="navbar navbar-default navbar-fixed-top" style="background-color:purple;color:white;">
    <img src="images/logop.png" alt="logo" width="70" height="70">
    <strong>RGU Research Paper Project</strong>


    <div id="nav-menu" class="collapse navbar-collapse navbar-right"  style="margin-top: 15px; margin-right: 110px">

        <a href="index.php" class=" w3-button w3-hover-purple w3-display-right" style="color: white; " > <h3>Go Back</h3></a>

    </div>
    </nav>
</header>
<!--Main container starts here-->
    <section id="header">
      <div class="container">

        <div class="row">

            <div class="col-sm-3">
            </div>


            <div class="col-xs-12 col-sm-9 hidden-xs" >

                <br/>
               <div>
                <h1>Welcome to RGU Research Paper Project <br> <small style="margin-left:250px">About us</small></h1>



                <br/><br/>
               </div>
<!--Second container with text FOR ABOUT US-->
<div class="container" style=" width:1200px;border: 5px solid purple;padding: 10px;margin-left:-200px;background-color: lightgrey;">
                <h2><a name="who" style="color: purple">Who we are</a></h2>
               <div><img src="images/RGU.jpg" width="150" alt="logo"></div>
                <br>
    <br>
                RGU delivers a high quality vocational education and relevant curriculum which provides learners with the skills they require to thrive throughout their careers. As a result, the university has a reputation for producing graduates that are highly sought after by employers. Over the last decade RGU has consistently had one of the best records of any UK university for graduate level employment. Its reputation for teaching excellence is demonstrated further through its Gold award in the UK Teaching Excellence Framework. It celebrates a high quality student experience and is currently ranked in the top three universities in Scotland for student satisfaction.
                <br>
    <br>
                RGU has a heritage going back 250 years and was awarded university status in 1992. Throughout its development, the university has remained committed to creating equal opportunities to access a relevant and valuable education. It is made up of eleven schools and offers over 300 courses ranging from engineering, architecture, computing, and life sciences to the creative industries, health and social care, and business. It has a student population of over 16,500, who study on-campus and online; notably, it is one of the largest providers of distance learning in the UK. Courses are developed through close collaboration with employers, professions and industry to address skills regional and national needs, and this ensures that curriculum is demand-led.

</div>
                <br>
                <br>
<!--Our Strategy Section Starts here-->
                <div  class="container" style=" width:1200px;border: 5px solid purple;padding: 10px;margin-left:-200px; background-color: lightgrey;">
                <h2><a name="Strategy" style="color: purple">Our Strategy</a></h2>
                <div><img src="images/building.jpg" width="300" alt="uni"></div>
                <br>
                RGU has a strategic mission to transform individuals and communities by providing demand-led teaching and research to contribute to economic, social and cultural development. To achieve this the university has established a strategy map which reflects its significant strengths in higher education.
                <br>
                <br>
                The closeness of RGU’s relationship with professional bodies and employers allows the university to develop a curriculum that addresses specific skills needs, extending the reach and relevance of its provision to drive employability and support individuals to thrive throughout their careers. It maintains a strong focus on providing learner opportunities for people of all backgrounds and at all stages of their careers. Its flexible, accessible curriculum and work-based learning opportunities support the upskilling and reskilling of both individuals and workforces.
                <br>
                <br>
                </div>

                <br>
                <br>
<!--Web Application Section Starts here-->
                <div class="container" style=" width:1200px;border: 5px solid purple;padding: 10px;margin-left:-200px;background-color: lightgrey;">
                <h2><a name="introduction" style="color: purple">1) Web Application Description</a></h2>
                    <div><img src="images/logop.png" width="150" alt="logo"></div>
                    <br>
                This project will be designing to implement a web application that will help group project to upload, identification, review, monitoring and following of research papers between the group members. The research activities will be report writing, review, editing and other similar tasks can be to monitor and track the editorial progress of a number of papers within a limited time. Furthermore, this project will give the opportunity for the user to create platform that will support group project teams.
                <br/><br/>
                In this system they will be three types of users: Administrator, Student Team Leader and Students. All users will have access to the register system i.e. members will be required to log in. The administrator has the highest Roles to manage the tools on the platform, and he will only has the access to create users, setup project groups, allocate team leader role and assign members to the project. The team leader is responsible for delivering papers to members for review and. Students will be able to upload research papers, this will be submitted to the Student team leader, who will allocate it to any members for review.
                </div>
                <br>
                <br>
<!--Project Constraints Section here-->
                <div class="container" style=" width:1200px;border: 5px solid purple;padding: 10px;margin-left:-200px;background-color: lightgrey;">
                <h2><a name="project_constraints" style="color: purple">2) Project Constraints</a></h2>
                <ol>
                    <li> 2.1 The web application must be hosted on a server with up-to-date code stored in Github:
                        <ol type='a'>
                            <br>
                            <li>The application will be hosted on a local server (csdm-webdev) accessible to all interested parties for use inside the University.</li>
                            <br>
                            <li> All codes will be available on github at <a href="https://github.com/stefanos03/PROJECT-RESEARCH-PAPER-SHARING-APP" target="_blank">https://github.com/stefanos03/PROJECT-RESEARCH-PAPER-SHARING-APP</a>. The name of repository is: PROJECT-RESEARCH-PAPER-SHARING-APP.</li>

                        </ol>
                    </li>
                    <br>
                    <li> 2.2 The application must contain both front end (client side) and (server side) code:
                        <ol type='a'>
                            <br>
                            <li>The front-end is the presentation layer that the user will use to perform tasks on the web app. The front-end is the user-friendly Graphical User Interface built. It is built using HTML, CSS, Font awesome and Bootstrap.</li>
                            <br>
                            <li>The back-end is the logic and data layer. It executes user's requests, by performing query based on the request and return response to the user on the front-end.</li>

                        </ol>
                    </li>
                    <br>
                    <li>2.3 The created web application must contain the following features:
                        <ol type='a'>
                            <br>
                            <li>A login system: This is a security mechanism to restrict application access to authorized users. This will be created using HTML, PHP, MySQL CSS and Bootstrap.</li>
                            <br>
                            <li>More than one user role: The application will be able to support users with different roles assigned various degrees of permissions and benefits in what a user is able of doing.</li>
                            <br>
                            <li>Some type of file upload system and: This will facilitate the uploading of research papers on the server for storing and download at request. This will be implemented using HTML and PHP for executing upload to remote server.</li>
                            <br>
                            <li> A system for user to input data that is stored and then recalled from a database: The system will support data storage for example documents or reviewing papers and retrieval using HTML, PHP in the application and MySQL(phpMyAdmin) for the database server.</li>
                        </ol>
                    </li>
                    </li>

                </ol>
                </div>

            </div>
        </div>
<!-- row ends-->
      </div>
<!-- Container ends-->
    </section>
<!--Foooter starts-->
<?php
   require_once("indexFooter.php");
?>
