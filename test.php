<?php
require_once 'BadgefeverSDK.php';
$bf = new BadgefeverSDK(array('badge-collector'=>1),'qwepoi6','c1435b89b4110a514d4412809ffb372d');

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
		echo $bf->hasBadge('test@badgefever.com',1);
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
		echo $bf->assignBadge(6,'test@badgefever.com');
	?>
</section>