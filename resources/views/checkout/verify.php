<?php

$pin = "n17n3ed0mo3374x"; // gateway pin

$url = 'http://core.paystar.ir/api/pardakht/verify/'; // don't change



if ($_POST['status'] == 1){

    $fields = array(
      'ref_num' => $_POST['ref_num'],
       'amount' => $_GET['amount']
    );
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $h = array('Authorization: Bearer '.$pin, 'Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = json_decode(curl_exec($ch));
    curl_close($ch);


}else{
   $result = new stdClass();
   $result->status = 0;

}

echo '
<!DOCTYPE html>
<html lang="fa">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="Designer" content="Developed by paystar.ir">
		<title>اسان پرداخت</title>
		<link rel="stylesheet" href="css/additionals.css">
		<link rel="stylesheet" href="css/style.css">

		<script src="javascript/jquery-1.11.0.min.js"></script>
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
  <body class="page-payment-redirect page-asanpardakht">
  	<div class="wrapper site-wrap" id="site_wrap">
   	 <div class="container">
      <div class="asanpardakht-box clearfix">
      	<div class="asanpardakht-description col-sm-6">
						<i class="icon-pay-per-click ap-icon"></i>
						<img src="images/ap.png" alt="Asan pardakht">
						<p>پرداخت یار پی استار، به لطف روش های متنوع پرداخت و امکانات ویژه خود همواره می کوشد تا پاسخگوی طیف وسیعی از نیازهای تراکنشی و مالی کاربران خود باشد.</p><p>آسان پرداخت پی استار، ابزاری پویا و مطمئن جهت تسهیل تراکنش بین مبداء و مقصد بوده که در آن مشتری با مشاهده مشخصات فروشنده و تعیین مبلغ تراکنش، اقدام به واریز وجه می نماید.</p>
						<p>لطفا قبل از انجام تراکنش از صحت نام فروشگاه و مبلغ پرداختی اطمینان حاصل فرمایید.جهت پیگیری تراکنش خود میتوانید به آدرس <a href="https://paystar.ir/followup">paystar.ir/followup</a> مراجعه کنید.</p>
					</div><!-- .asanpardakht-description -->



        <div class="asanpardakht-form col-sm-6">
						<div class="vendor-information clearfix">
							<div class="vendor-logo col">
								<img src="images/sample/your_logo.png" alt="logo">
							</div><!-- .vendor-logo -->

							<div class="details col">
								<span class="ttl">اطلاعات پذیرنده</span>
								<h2 class="vendor-name">نام وب سایت شما</h2>
								<a href=""><i class="icon-link"></i> www.example.com</a>
							</div><!-- .detail -->

							<div class="clearfix"></div>
						</div><!-- .vendor-information -->

						<span class="shadow"></span>

						<div class="pre-payment">
							<span class="icon-logo go-left"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
							<h2 class="ap-title">آسان پرداخت</h2>
							<p>با تشکر. نتیجه عملیات شما به شرح زیر است :</p>
							</div>
						<div class="row">

';
if($result->status == "1"){
    echo '<span style="color:green;font-size: 18px;display: block;text-align: center;">پرداخت شما با موفقیت انجام شد !</span>';
} else if ($result->status == "0") {
   echo '<span style="color:red;font-size: 18px;display: block;text-align: center;">متاسفیم! پرداخت شما موفقیت امیز نبود.</span><hr>درصورت کسر شدن موجودی از حسابتان ،‌ظرف ۷۲ ساعت اینده از سمت بانک برگشت داده میشود.';
}
else {
   echo '<span style="color:red;font-size: 18px;display: block;text-align: center;">کد خطا : '.$result->status.'</span>';
}
echo '
                	</div>
                </div><!-- .asanpardakht-form -->
			</div><!-- .asanpardakht-box -->
		</div><!-- .container -->

			<footer class="payment-footer">
				<p class="copyright">© 2017 PayStar </p>
			</footer>

			<div class="accepted-baks"><img src="images/sample/banks-ver.png" alt="banks"></div>

		</div><!-- #site_wrap -->
		<script src="javascript/plugins.js"></script>
		<script src="javascript/main.js"></script>
	</body>
</html>';
