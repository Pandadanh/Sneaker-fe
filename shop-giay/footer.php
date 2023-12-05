<footer>
    <div class="container mt-5 py-5" style="max-width: 1550px;">
        <div class="row d-flex justify-content-between">
            <div class="footer-menu col-lg-3 col-md-6 px-2 col-12">
                <h2 class="footer-title">CHÍNH SÁCH</h2>
                <ul class="footer-ul">
                    <li>
                        <a href="">Chính sách bảo hành</a>
                    </li>
                    <li>
                        <a href="">Chính sách đổi trả</a>
                    </li>
                    <li>
                        <a href="">Chính sách giao nhận hàng</a>
                    </li>
                    <li>
                        <a href="">Chính sách bảo mật</a>
                    </li>
                    <li>
                        <a href="">Hướng dẫn sử dụng Fundiin trả góp giày đá banh</a>
                    </li>
                    <li>
                        <a href="">Hướng dẫn thanh toán kỳ 2 & 3 cho Fundiin</a>
                    </li>
                    <li>
                        <a href="">Các câu hỏi thường gặp với Fundiin</a>
                    </li>
                    <li>
                        <a href="">Chương trình Khách Hàng Thân Thiết</a>
                    </li>
                </ul>
            </div>
            <div class="footer-menu col-lg-3 col-md-6 px-2 col-12">
                <h2 class="footer-title">VỀ THF</h2>
                <ul class="footer-ul">
                    <li><a href="">Về chúng tôi</a></li>
                    <li><a href="">Lĩnh vực kinh doanh</a></li>
                    <li>
                        <a href="">THF I: 27 Đường D52, P. 12, Q. Tân Bình, TP. HCM | Hotline:
                            0901 710 780 - 028 38429720</a>
                    </li>
                    <li>
                        <a href="">THF II: 32A Thạch Thị Thanh, P. Tân Định, Q. 1, TP. HCM |
                            Hotline: 0901 710 730</a>
                    </li>
                </ul>
            </div>

            <div class="footer-sub col-lg-3 col-md-6 px-2 col-12">
                <div class="footer-wrap">
                    <h2 class="footer-title">FACEBOOK</h2>
                    <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fthanhhungfutsal&amp;tabs=timeline%2Cevents%2Cmessages&amp;width=300&amp;height=330&amp;small_header=false&amp;adapt_container_width=true&amp;hide_cover=false&amp;hide_cta=true&amp;show_facepile=false&amp;appId" width="100%" height="300px" style="border: none; overflow: hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                </div>
            </div>

            <div class="footer-sub col-lg-3 col-md-6 px-2 col-12">
                <div class="footer-wrap">
                    <h2 class="footer-title">INSTAGRAM</h2>
                    <div class="container">

                        <?php


                        $apiUrl = 'http://localhost:8080/api/controller-page/footer/';
                        $curl = curl_init($apiUrl);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($curl);
                        curl_close($curl);

                        $data = json_decode($response, true);

                    
                        $result = $data['data'];
                        foreach ($result as $row) {
                            if ($row['tenmxh'] == "Facebook" && $row["url"] != "") {
                                echo ' <a href="' . $row["url"] . '"><img  style="border-radius:  50%; width: 14%;height: 14%; margin: 10px;" src="./icon/facebook_480px.png"> </a>';
                            }
                            if ($row['tenmxh'] == "Instagram" && $row["url"] != "") {
                                echo ' <a href="' . $row["url"] . '"><img style="border-radius: 50%; width: 14%;height: 14%; margin: 10px;" src="./icon/instagram_480px.png"></a>';
                            }
                            if ($row['tenmxh'] == "LinkedIn" && $row["url"] != "") {
                                echo ' <a href="' . $row["url"] . '"><img style="border-radius: 50%; width: 14%;height: 14%; margin: 10px;" src="./icon/linkedin_480px.png">
                                </a>';
                            }
                            if ($row['tenmxh'] == "Twitter" && $row["url"] != "") {
                                echo ' <a href="' . $row["url"] . '"><img style="border-radius: 50%; width: 14%;height: 14%; margin: 10px;" src="./icon/twitter_480px.png">
                                </a>';
                            }
                            if ($row['tenmxh'] == "WhatsApp" && $row["url"] != "") {
                                echo ' <a href="' . $row["url"] . '"><img style="border-radius: 50%; width: 14%;height: 14%; margin: 10px;" src="./icon/whatsapp_480px.png">
                                </a>';
                            }
                            if ($row['tenmxh'] == "YouTube" && $row["url"] != "") {
                                echo ' <a href="' . $row["url"] . '">                            
                                    <img style="border-radius: 50%; width: 14%;height: 14%; margin: 10px;" src="./icon/youtube_480px.png"> </a>';
                            }
                        }
                        ?>
                        <div class="icon-container" style="display: flex; justify-content: center;">


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>