# rest

## Hakkında

Bu proje laravel 8.1, ile geliştirilmiş, development ortamı laravel/sail ile docker üzerine kurulu basit bir rest api sistemidir.

* php versiyonu: 8.1.7
* mysql versiyonu: 8.0.29

## Kurulum
### Gereksinimler
* Linux, MacOS veya WSL2 kurulu Windows işletim sistemi
* php 8.1 ve üzeri bir php sürümü
* composer
* docker

#
* Projeyi çektikten sonra ilk olarak ***.env.example*** dosyasından kendi ***.env*** dosyamızı türetiyoruz. Gerekliyse düzenleme yapıyoruz.
* ***composer install***
* ***php artisan key:generate***
* ***./vendor/bin/sail up*** komutunu çalıştırıyoruz.
* ***./vendor/bin/sail shell***
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
