<?php
    ob_start();
    session_start();
    include('../database/connect.php');

    $accID = $_SESSION['accID'];

    $ticketPrice = $_SESSION['ticket_price'];
    $voucher_ID = $_SESSION['voucher'];
    // echo $voucher_ID;
    if($voucher_ID != null){
        $dataVoucher = getVoucherByVoucherID($voucher_ID);
        $voucherPrice = $dataVoucher['voucher_Discount'];
    }else{
        $voucherPrice = 0;
    }
    // echo $voucher_ID;
    // echo $voucherPrice;

    $sum = $ticketPrice - (floatval($voucherPrice) * $ticketPrice) / 100;
    
    $VND_money = $sum * 23447.50;

    // $total_Price = $_SESSION['total_Price'];
    // echo $total_Price;

    // echo $sumTicketPrice;
    // echo $voucher_input_ID;

    $dataAcc = getCusByCusID($accID);

    $cus_Name = $dataAcc['cus_Name'];
    $cus_Email = $dataAcc['cus_Email'];
    $cus_Address = $dataAcc['cus_Address'];
    $cus_Phone = $dataAcc['cus_Phone_number'];
    $cus_DOB = $dataAcc['cus_DOB'];
    $cus_Sex = $dataAcc['cus_Sex'];

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Create a new order</title>
        <!-- Bootstrap core CSS -->
        <link href="/vnpay_php/assets/bootstrap.min.css" rel="stylesheet"/>
        <!-- Custom styles for this template -->
        <link href="/vnpay_php/assets/jumbotron-narrow.css" rel="stylesheet">  
        <script src="/vnpay_php/assets/jquery-1.11.3.min.js"></script>
    </head>

    <body>
        <?php require_once("./config.php"); ?>             
        <div class="container">
            <div class="header clearfix">
                <h3 class="text-muted">VNPAY DEMO</h3>
            </div>
            <h3>Tạo mới đơn hàng (Create a new order)</h3>
            <div class="table-responsive">
                <form action="/vnpay_php/vnpay_create_payment.php" id="create_form" method="post">       

                    <div class="form-group">
                        <label for="language">Loại hàng hóa (Commodities) </label>
                        <select name="order_type" id="order_type" class="form-control">
                            <option value="topup">Nạp tiền điện thoại (Recharge your phone)</option>
                            <option value="billpayment">Thanh toán hóa đơn (Pay the bill)</option>
                            <option value="fashion">Thời trang (Fashion)</option>
                            <option value="other">Khác - Xem thêm tại VNPAY (Other - See more at VNPAY)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="order_id">Mã hóa đơn (Order Code)</label>
                        <input class="form-control" id="order_id" name="order_id" type="text" value="<?php echo date("YmdHis") ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="amount">Số tiền (money)</label>
                        <input class="form-control" id="amount"
                               name="amount" type="number" value="<?= $VND_money ?>"/>
                    </div>
                    <div class="form-group">
                        <label for="order_desc">Nội dung thanh toán (Content billing)</label>
                        <textarea class="form-control" cols="20" id="order_desc" name="order_desc" rows="2">Noi dung thanh toan</textarea>
                    </div>
                    <div class="form-group">
                        <label for="bank_code">Ngân hàng (Bank)</label>
                        <select name="bank_code" id="bank_code" class="form-control">
                            <option value="">Không chọn (No choice)</option>
                            <option value="NCB"> Ngan hang NCB</option>
                            <option value="AGRIBANK"> Ngan hang Agribank</option>
                            <option value="SCB"> Ngan hang SCB</option>
                            <option value="SACOMBANK">Ngan hang SacomBank</option>
                            <option value="EXIMBANK"> Ngan hang EximBank</option>
                            <option value="MSBANK"> Ngan hang MSBANK</option>
                            <option value="NAMABANK"> Ngan hang NamABank</option>
                            <option value="VNMART"> Vi dien tu VnMart</option>
                            <option value="VIETINBANK">Ngan hang Vietinbank</option>
                            <option value="VIETCOMBANK"> Ngan hang VCB</option>
                            <option value="HDBANK">Ngan hang HDBank</option>
                            <option value="DONGABANK"> Ngan hang Dong A</option>
                            <option value="TPBANK"> Ngân hàng TPBank</option>
                            <option value="OJB"> Ngân hàng OceanBank</option>
                            <option value="BIDV"> Ngân hàng BIDV</option>
                            <option value="TECHCOMBANK"> Ngân hàng Techcombank</option>
                            <option value="VPBANK"> Ngan hang VPBank</option>
                            <option value="MBBANK"> Ngan hang MBBank</option>
                            <option value="ACB"> Ngan hang ACB</option>
                            <option value="OCB"> Ngan hang OCB</option>
                            <option value="IVB"> Ngan hang IVB</option>
                            <option value="VISA"> Thanh toan qua VISA/MASTER</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="language">Ngôn ngữ (Language)</label>
                        <select name="language" id="language" class="form-control">
                            <option value="vn">Tiếng Việt (Vietnamese)</option>
                            <option value="en">English</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label >Thời hạn thanh toán (Payment term)</label>
                        <input class="form-control" id="txtexpire"
                               name="txtexpire" type="text" value="<?php echo $expire; ?>"/>
                    </div>
                    <div class="form-group">
                        <h3>Thông tin hóa đơn (Billing)</h3>
                    </div>
                    <div class="form-group">
                        <label >Họ tên (*) (Full name)</label>
                        <input class="form-control" id="txt_billing_fullname"
                               name="txt_billing_fullname" type="text" value="NGUYEN VAN XO"/>             
                    </div>
                    <div class="form-group">
                        <label >Email (*)</label>
                        <input class="form-control" id="txt_billing_email"
                               name="txt_billing_email" type="text" value="xonv@vnpay.vn"/>   
                    </div>
                    <div class="form-group">
                        <label >Số điện thoại (*) (Phone number)</label>
                        <input class="form-control" id="txt_billing_mobile"
                               name="txt_billing_mobile" type="text" value="0934998386"/>   
                    </div>
                    <div class="form-group">
                        <label >Địa chỉ (*) (Address)</label>
                        <input class="form-control" id="txt_billing_addr1"
                               name="txt_billing_addr1" type="text" value="22 Lang Ha"/>   
                    </div>
                    <div class="form-group">
                        <label >Mã bưu điện (*) (ZIP code) </label>
                        <input class="form-control" id="txt_postalcode"
                               name="txt_postalcode" type="text" value="100000"/> 
                    </div>
                    <div class="form-group">
                        <label >Tỉnh/TP (*) (Province/City) </label>
                        <input class="form-control" id="txt_bill_city"
                               name="txt_bill_city" type="text" value="Hà Nội"/> 
                    </div>
                    <div class="form-group">
                        <label>Bang (Áp dụng cho US,CA) (State (Applies to US, CA))</label>
                        <input class="form-control" id="txt_bill_state"
                               name="txt_bill_state" type="text" value=""/>
                    </div>
                    <div class="form-group">
                        <label >Quốc gia (*) (Nation)</label>
                        <input class="form-control" id="txt_bill_country"
                               name="txt_bill_country" type="text" value="VN"/>
                    </div>
                    <div class="form-group">
                        <h3>Thông tin giao hàng (Shipping)</h3>
                    </div>
                    <div class="form-group">
                        <label >Họ tên (*) (Full name)</label>
                        <input class="form-control" id="txt_ship_fullname"
                               name="txt_ship_fullname" type="text" value="Nguyễn Thế Vinh"/>
                    </div>
                    <div class="form-group">
                        <label >Email (*)</label>
                        <input class="form-control" id="txt_ship_email"
                               name="txt_ship_email" type="text" value="vinhnt@vnpay.vn"/>
                    </div>
                    <div class="form-group">
                        <label >Số điện thoại (*) (Phone number) </label>
                        <input class="form-control" id="txt_ship_mobile"
                               name="txt_ship_mobile" type="text" value="0123456789"/>
                    </div>
                    <div class="form-group">
                        <label >Địa chỉ (*) (Address)</label>
                        <input class="form-control" id="txt_ship_addr1"
                               name="txt_ship_addr1" type="text" value="Phòng 315, Công ty VNPAY, Tòa nhà TĐL, 22 Láng Hạ, Đống Đa, Hà Nội"/>
                    </div>
                    <div class="form-group">
                        <label >Mã bưu điện (*) (ZIP Code) </label>
                        <input class="form-control" id="txt_ship_postalcode"
                               name="txt_ship_postalcode" type="text" value="1000000"/>
                    </div>
                    <div class="form-group">
                        <label >Tỉnh/TP (*) (Province/City)</label>
                        <input class="form-control" id="txt_ship_city"
                               name="txt_ship_city" type="text" value="Hà Nội"/>
                    </div>
                    <div class="form-group">
                        <label>Bang (Áp dụng cho US,CA) (State (Applies to US, CA))</label>
                        <input class="form-control" id="txt_ship_state"
                               name="txt_ship_state" type="text" value=""/>
                    </div>
                    <div class="form-group">
                        <label >Quốc gia (*) (Nation)</label>
                        <input class="form-control" id="txt_ship_country"
                               name="txt_ship_country" type="text" value="VN"/>
                    </div>
                    <div class="form-group">
                        <h3>Thông tin gửi Hóa đơn điện tử (Invoice)</h3>
                    </div>
                    <div class="form-group">
                        <label >Tên khách hàng (Customer Name)</label>
                        <input class="form-control" id="txt_inv_customer"
                               name="txt_inv_customer" type="text" value="<?= $cus_Name ?>"/>
                    </div>
                    <div class="form-group">
                        <label >Công ty (Company)</label>
                        <input class="form-control" id="txt_inv_company"
                               name="txt_inv_company" type="text" value=""/>
                    </div>
                    <div class="form-group">
                        <label >Địa chỉ (Address)</label>
                        <input class="form-control" id="txt_inv_addr1"
                               name="txt_inv_addr1" type="text" value="<?= $cus_Address ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Mã số thuế (Tax code)</label>
                        <input class="form-control" id="txt_inv_taxcode"
                               name="txt_inv_taxcode" type="text" value=""/>
                    </div>
                    <div class="form-group">
                        <label >Loại hóa đơn (Bills)</label>
                        <select name="cbo_inv_type" id="cbo_inv_type" class="form-control">
                            <option value="I">Cá Nhân (Individual)</option>
                            <option value="O">Công ty/Tổ chức (Company/Organization)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label >Email</label>
                        <input class="form-control" id="txt_inv_email"
                               name="txt_inv_email" type="text" value="<?= $cus_Email ?>"/>
                    </div>
                    <div class="form-group">
                        <label >Điện thoại (Phone number)</label>
                        <input class="form-control" id="txt_inv_mobile"
                               name="txt_inv_mobile" type="text" value="<?= $cus_Phone ?>"/>
                    </div>
                    <button type="submit" class="btn btn-primary" id="btnPopup">Thanh toán Post (Post Payment)</button>
                    <button type="submit" name="redirect" id="redirect" class="btn btn-default">Thanh toán Redirect (Redirect Payment)</button>

                </form>
            </div>
            <p>
                &nbsp;
            </p>
            <footer class="footer">
                <p>&copy; VNPAY <?php echo date('Y')?></p>
            </footer>
        </div>  
       
         


    </body>
</html>
