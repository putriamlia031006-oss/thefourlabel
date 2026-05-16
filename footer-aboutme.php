<style>
    /* --- TEMA LAVENDER CONTACT & FOOTER --- */
    #contact.paralax-mf {
        position: relative;
        padding: 8rem 0;
    }

    /* Mengubah tombol kirim menjadi ungu lavender */
    .button-lavender {
        background-color: #967BB6;
        color: #fff;
        border: 0;
        padding: 12px 30px;
        transition: all 0.4s ease-in-out;
        border-radius: 5px;
    }

    .button-lavender:hover {
        background-color: #6A5ACD;
        color: #fff;
        box-shadow: 0 0 0 4px #E6E6FA;
    }

    /* Overlay nuansa ungu lembut */
    .overlay-mf-lavender {
        background-color: rgba(150, 123, 182, 0.7);
        position: absolute;
        top: 0;
        left: 0;
        padding: 0;
        height: 100%;
        width: 100%;
        opacity: .7;
    }

    /* Lingkaran icon sosial media */
    .socials .ico-circle {
        height: 40px;
        width: 40px;
        font-size: 1.2rem;
        border-radius: 50%;
        line-height: 1.4;
        margin: 0 15px 0 0;
        box-shadow: 0 0 0 3px #967BB6;
        transition: all 500ms ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #1e1e1e;
    }

    .socials .ico-circle:hover {
        background-color: #967BB6;
        color: #fff;
        box-shadow: 0 0 0 3px #E6E6FA;
    }

    /* Warna icon info kontak */
    .list-ico span {
        color: #967BB6;
        margin-right: 10px;
    }

    /* Footer styling */
    footer {
        text-align: center;
        color: #fff;
        padding: 25px 0;
        background: #6A5ACD; /* Ungu gelap untuk kontras */
    }

    .copyright-box {
        margin-top: 15px;
    }
</style>

<section id="contact" class="paralax-mf footer-paralax bg-image sect-mt4 route" style="background-image: url(image/lavender3.jpg)">
  <div class="overlay-mf-lavender"></div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="contact-mf">
          <div id="contact" class="box-shadow-full">
            <div class="row">
              <div class="col-md-6">
                <div class="title-box-2">
                  <h5 class="title-left">Kirim Pesan</h5>
                </div>
                <div>
                  <form id="contact-form" class="contact-form-custom">
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                          <input type="text" name="user_name" class="form-control" id="name" placeholder="Nama Anda" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                          <input type="email" name="user_email" class="form-control" id="email" placeholder="Email Anda" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                          <input type="text" name="subject" class="form-control" id="subject" placeholder="Subjek" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-3">
                        <div class="form-group">
                          <textarea name="message" class="form-control" rows="5" placeholder="Isi Pesan" required></textarea>
                        </div>
                      </div>
                      <div class="col-md-12 text-center">
                        <button type="submit" id="submit-btn" class="button-lavender button-big shadow">Kirim Pesan</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-md-6">
                <div class="title-box-2 pt-4 pt-md-0">
                  <h5 class="title-left">Hubungi Kami</h5>
                </div>
                <div class="more-info">
                  <p class="lead">
                    Berbelanja di toko fashion kami adalah sebuah pengalaman eksklusif yang dirancang secara personal. Setiap koleksi dipilih dengan detail dan kualitas terbaik dengan sentuhan Lavender yang elegan.
                  </p>
                  <ul class="list-ico">
                    <li><span class="bi bi-geo-alt"></span> Ruko Fashion Square Kav. 12, Tangerang</li>
                    <li><span class="bi bi-phone"></span> (62) 838-7123-6672</li>
                    <li><span class="bi bi-envelope"></span> info@thefourlabel.com</li>
                  </ul>
                </div>
                <div class="socials">
                  <ul>
                    <li><a href="https://wa.me/6283878589052"><span class="ico-circle"><i class="bi bi-whatsapp"></i></span></a></li>
                    <li><a href="https://www.instagram.com/ptr.hijklnomihc"><span class="ico-circle"><i class="bi bi-instagram"></i></span></a></li>
                    <li><a href="https://x.com/amlia031006"><span class="ico-circle"><i class="bi bi-twitter"></i></span></a></li>
                    <li><a href="https://www.tiktok.com/@molla_lala"><span class="ico-circle"><i class="bi bi-tiktok"></i></span></a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<footer>
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="copyright-box">
          <p class="copyright">© 2026 <strong>THE FOUR LABEL</strong>. SI 24 P SIM 2</p>
          <div class="credits">
            Designed by<br>
            <span class="text-lavender-light" style="color: #E6E6FA;">Cindi Setio Rhamadani, Khanza Afifah Karina Putri, Putri Amalia Ramdani, Putri Sofiatun Muzofar</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
   (function(){
      emailjs.init("WY9271-9AiCahPXrC"); 
   })();

   document.getElementById('contact-form').addEventListener('submit', function(event) {
      event.preventDefault();

      const btn = document.getElementById('submit-btn');
      btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim...';
      btn.disabled = true;

      const serviceID = 'service_ssnpe3a';
      const templateID = 'template_99tkmva';

      emailjs.sendForm(serviceID, templateID, this)
        .then(() => {
          btn.innerText = 'Kirim Pesan';
          btn.disabled = false;

          Swal.fire({
            icon: 'success',
            title: 'Pesan Terkirim!',
            text: 'Terima kasih, pesan Anda sudah masuk ke Gmail Gassspol.',
            confirmButtonColor: '#967BB6', // Warna konfirmasi lavender
            showClass: {
                popup: 'animate__animated animate__fadeInUp'
            }
          });

          document.getElementById('contact-form').reset();
        }, (err) => {
          btn.innerText = 'Kirim Pesan';
          btn.disabled = false;

          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Gagal mengirim pesan. Silakan coba lagi nanti.',
            confirmButtonColor: '#6A5ACD'
          });
          console.log('FAILED...', err);
        });
   });
</script>

