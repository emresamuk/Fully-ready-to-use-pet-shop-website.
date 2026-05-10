# 🐾 Drool Pet Shop - Web Tabanlı E-Ticaret & CMS Platformu

Bu proje, içerik yönetim sistemine sahip tam kapsamlı bir e-ticaret platformudur.

---

## 📋 Proje Hakkında
Drool Pet Shop; evcil hayvan ürünlerinin tanıtımı, satışı ve sipariş süreçlerinin yönetimini sağlayan, **Laravel MVC** mimarisi üzerine kurulu bir web uygulamasıdır. Sistem, admin ve kullanıcı rollerine dayalı bir yetkilendirme yapısına sahiptir.

## 🛠 Teknik Özellikler & İsterler
Proje, dersin tüm teknik isterlerini karşılayacak şekilde aşağıdaki özelliklerle donatılmıştır:

* **Rol Yönetimi:** Sistemde Admin ve User olmak üzere iki ana rol bulunmaktadır.
* **İçerik Yönetimi (CMS):** Admin paneli üzerinden ürün ekleme, güncelleme, silme ve stok kontrolü yapılabilmektedir.
* **Sanal Cüzdan & İade:** Sipariş iptal edildiğinde tutar, kullanıcının site içi bakiyesine (hediye olarak) iade edilir. Kullanıcı, yeni alışverişlerinde bu bakiyeyi öncelikli olarak kullanır.
* **Sipariş Takibi:** Admin sipariş durumunu adım adım (tedarik, kargo, teslim vb.) ilerletir; kullanıcı bu süreci anlık takip edebilir.
* **Stok ve Veri Güvenliği:** Tüm satın alma işlemleri **DB Transactions** katmanında yönetilerek veri bütünlüğü ve stok doğruluğu garanti altına alınmıştır.
* **E-Posta Simülasyonu:** Şifre sıfırlama ve bildirim süreçleri için **Mailtrap** entegrasyonu kullanılmıştır.
* **Responsive Tasarım:** Arayüz, Bootstrap kullanılarak tüm cihazlara (Mobil/Tablet/PC) uyumlu şekilde geliştirilmiştir.

## 💻 Kullanılan Teknolojiler
- **Backend:** PHP 8.x, Laravel 10.x / 11.x
- **Frontend:** Blade Template Engine, CSS3, JavaScript, Bootstrap 5
- **Veritabanı:** MySQL
- **Test & SMTP:** Mailtrap
- **Versiyon Kontrol:** Git & GitHub

## 🚀 Kurulum Adımları

Projenin yerel ortamda (Localhost) çalıştırılması için aşağıdaki adımları izleyin:

1.  **Repoyu Klonlayın:**
    ```bash
    git clone [https://github.com/emresamuk/drool-pet-shop.git](https://github.com/emresamuk/drool-pet-shop.git)
    cd drool-pet-shop
    ```

2.  **Bağımlılıkları Yükleyin:**
    ```bash
    composer install
    npm install && npm run dev
    ```

3.  **Yapılandırma:**
    `.env.example` dosyasını `.env` olarak kopyalayın ve veritabanı bilgilerinizi girin. Ardından uygulama anahtarını oluşturun:
    ```bash
    php artisan key:generate
    ```

4.  **Veritabanı ve Örnek Veriler:**
    Migration'ları çalıştırın ve sistemin hazır gelmesi için seed'leri (Örnek ürünler ve test kullanıcıları) yükleyin:
    ```bash
    php artisan migrate --seed
    ```

5.  **Sunucuyu Başlatın:**
    ```bash
    php artisan serve
    ```

## 📊 Veritabanı Mimarisi
Proje kapsamında hazırlanan **Varlık-İlişki (ER) Diyagramı** uyarınca; `users`, `products`, `orders` ve `order_items` tabloları arasında ilişkisel bir bağ kurulmuştur. Veritabanı şeması, mühendislik prensiplerine uygun olarak normalizasyon kurallarına göre tasarlanmıştır.

## 📧 İletişim & Sunum
- **Geliştirici:** Emre Samuk
- **Kurum:** Kocaeli Üniversitesi Teknoloji Fakültesi

---
*Bu proje akademik amaçlarla geliştirilmiştir*
