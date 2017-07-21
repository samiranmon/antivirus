<?php
?>
<!DOCTYPE html>
<html>
<body>

<form method="post" action="requestcheckout.php">
  Amount:<br>
  <input type="text" name="amount">
  <br>
  Phonenumber:<br>
  <input type="text" name="number" placeholder="2547111111111">
  <br>
  Pay via MPESA:<br>
  <button type="submit" name="checkout" ><img src="m.jpg"></button>
</form>

<p>NB: Since this sample uses a real paybill number it makes real transactions. Hence encouraged to test with the lowest amount 10/=</p>



</body>
</html>
