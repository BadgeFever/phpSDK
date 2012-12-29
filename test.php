<?php
require_once 'BadgefeverSDK.php';
$bf = new BadgefeverSDK('qwepoi61','bad70078c9c559d4dc7167b6e05d0049');

?>
<section>
	<h1>Display Badges for test@badgefever.com (GET)</h1>
	<?php
		echo $bf->getBadges('test@badgefever.com',array('format'=>'html','size'=>'medium'));
	?>
</section>

<section>
	<h1>Did email test@badgefever.com achieved badge 1? (GET)</h1>
	<?php
		echo $bf->hasBadge('test6@badgefever.com',2);
	?>
</section>

<section>
    <h1>How many times has been badge 1 assigned? (GET)</h1>
	<?php
		echo $bf->getAssignCount(1);
	?>
</section>

<section>
    <h1>Assign Badge 1 to test@badgefever.com (POST)</h1>
	<?php
		echo $bf->assignBadge(1,'test@badgefever.com',array('level'=>1));
	?>
</section>