<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/event_description.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Event Description</title>
</head>
<body>

        <?php
            include 'nav.php'
        ?>
			<div id="topSection" class="grad1">
				<div id="attentionText">
					<h1  id="sEventName" class="whiteBg"><span> Event Name <span></h1>
				</div>
			</div>

			<div id="descriptionBox">
				<div class="topBar">
					<ul>
						<li id="filterUiBtn">UI</li>
						<li id="sDate">DATE: 15.12.2017</li>
						<li id="iTime">TIME: 15:00</li>
						<li><a href="">Speaker:</a id="sSpeaker"> Emma Happy</li>
					</ul>
				</div>
				<div class="description">
						<section class="descriptionSection">
							<h3>Requirements: </h3>
							<p> Photoshop, Illustrator, Lorem Ipsum</p>
						</section>
						<section class="descriptionSection">
							<h3>Requirements: </h3>
							<p> Photoshop, Illustrator, Lorem Ipsum</p>
						</section>
						<section class="descriptionSection">
							<h3>Requirements: </h3>
							<p> Photoshop, Illustrator, Lorem Ipsum</p>
						</section>
						<section class="descriptionSection">
							<p> Lorem ipsum dolor sit amet, consectetur adipiscing
								elit. Aliquam sit amet porttitor leo. Pellentesque 
								vestibulum condimentum mollis. Sed tincidunt enim vitae 
								arcu eleifend, eu blandit nisi tincidunt. Curabitur tellus 
								massa, scelerisque at turpis a, elementum lacinia mi. Nulla 
								lacinia neque commodo dolor posuere, vel convallis justo finibus. 
								Quisque ac lobortis ligula, quis vestibulum ipsum. Cras neque enim,
								malesuada in sollicitudin varius, dictum vel lacus. Sed id nunc non
								tortor convallis hendrerit. Proin malesuada elit vel orci tincidunt
								euismod. Quisque laoreet, sapien et iaculis consectetur, libero leo
								vehicula dui, a auctor mi ante quis felis. Nullam ultricies risus sit amet leo placerat, pellentesque luctus mi malesuada.
								 Aenean ullamcorper, tellus id consectetur consectetur, risus leo malesuada nibh, eu imperdiet eros purus tincidunt orci. 
								 Curabitur in nunc non urna mollis venenatis. Sed viverra tempor ipsum id dignissim. Nulla auctor fringilla feugiat.</p>
						</section>
                    </div>

                    <section class="buttonSection">
                        <button id="btnParticipate">Participate IN EVENT</button>
                        <button id="btnCancel">Cancel</button>
                    </section>    
                    
			</div>
			
	
</body>
<footer>
        <?php
                include 'footer.html'
        ?>
</footer>
</html>