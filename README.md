## т.з.

## plugins:  

фикс/стики скролл:  
https://github.com/leafo/sticky-kit  

ytplayer (уже вклучен):  
https://github.com/pupunzi/jquery.mb.YTPlayer/wiki  

isotope (yже вклучен):
http://isotope.metafizzy.co/  

swiper (как в DIS, уже вклучен):  
http://www.idangero.us/sliders/swiper/   

wordpress:
cusom feilds & custom feild repeater:  
http://www.advancedcustomfields.com/  

## SASS:

****  
у всех елементов уже стоит:  
box-sizing:border-box;  
(http://www.paulirish.com/2012/box-sizing-border-box-ftw/)  
так что можно спокойно ставить:  
.mydiv{  
  width:100%;  
  padding:100px;  
}   
и ширина останетса 100%;  
это упрощает все респонсив элементы  
:)   
****    

вместо  
'''
.calls1 .classtwo{  
  ...    
}  
.calls1 .classthree{  
  ...    
}  
'''
теперь:  
'''
.class1{  
  .class2{  
    ...  
  }  
  .class3{  
    ...  
  }  
}  
'''

чтобы SASS работал:  
нужно установить ruby: http://rubyinstaller.org/  
потом:   
gem update --system  
gem install compass  
gem install animation --pre    
  
организация в mdl/css фолдере  
вся анимация через css, в основном используя:   
@include transition(opacity, 1s, ease-in-quart())  
в _easing.scss список easing функций  
  
или animate через keyframes если нужно:  
@include animation(splash-fade 5s);   
  
## RESPONSIVE    
 
3 варианта:   
десктоп, таблет, мобил  
таблет: 
* моб. меню
* objects: 3 колонки 
* все остальное макс. 2 колонки  
моб.: 
* objects 2 колонки 
* все остальное 1 колонка  
 
ширина всех елементов в %  
padding, margin в основном в px, и по усмотрению  

## CMS организация  
   
Custom post types:  
* Books  
* Objects  
* Designers  
* Manufacturers  
* Press  
* TV  
  
Pages:  
* Front-page quote  
* About  
* Antiques of the Future (текст архива)  
* The Show (для текста TV)  
  
Custom fields:  
Objects:    
 *  Designer - custom feild ссылка на пост Дезайнера  
Аbout  
 *  Subtitle  
 *  Collaborations  
ТV  
 *  Subtitle  
 *  Video Url  
Press  
* Url  
* Date  
  
Menu  
-заполняем через wordpress  
  
## H2  
APP.JS  

роутер уже установлен и работает, можно писать обычные линки и он сам разберется.  
отклучить его можно используя class="external"  (eто только нужно для ссылок на внутринние pdf на пример)  
  
распозновать страницы можно через атрибут data-info элемента #content   
 
есть код для Search - твой из TWAAS  
eго нужно будет подправить  

есть код для Infinte Scroll  
должен работать, но нужно будет подключить к Isotope  




