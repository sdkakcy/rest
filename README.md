# rest

## Hakkında

Bu proje laravel 8, ile geliştirilmiş, development ortamı laravel/sail ile docker üzerine kurulu basit bir rest api sistemidir.

* php versiyonu: 8.1.7
* mysql versiyonu: 8.0.29

## Kurulum
### Gereksinimler
* php 8.0 ve üzeri bir php sürümü
* composer
* docker

#
* Projeyi çektikten sonra ilk olarak ***.env.example*** dosyasından kendi ***.env*** dosyamızı türetiyoruz. Gerekli ayarlamaları yapıyoruz.
* ***php artisan key:generate***
* ***composer install***
* ***./vendor/bin/sail up*** komutunu çalıştırıyoruz.
* Sail ile devam edeceksek ***./vendor/bin/sail shell***
* ***php artisan migrate --seed***

***
## Kılavuz
* Host: http://localhost
* Api: http://localhost/api

* E-posta: turker@jonturk.com
* Şifre: password

* E-posta: kaptan@devopuz.com
* Şifre: password

* E-posta: isa@sonuyumaz.com
* Şifre: password

* Postman collection'ı insert ettikten sonra login requestini kullanarak diğer endpointler test edilebilir.
