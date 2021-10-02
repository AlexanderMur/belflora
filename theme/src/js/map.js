import $ from 'jquery';

const mapBlock = {
  init() {
    $(window).on('load', function () {
      const mapElem = document.querySelector('#map');
      const markers = [
        {
          positionX: 50.598679,
          positionY: 36.581482
        },
        {
          positionX: 50.585973,
          positionY: 36.623847
        },
      ];
      if (mapElem) {
        let iconSize;
        let iconPosition;

        if ($(window).width() > 769) {
          iconSize = [60, 68];
          iconPosition = [-30, -68];
        } else {
          iconSize = [32, 36];
          iconPosition = [-16, -36];
        }

        ymaps.ready(function () {
          const myMap = new ymaps.Map("map", {
            center: [50.593308, 36.606297],
            zoom: 13
          });
          markers.forEach((elem) => {
            myMap.geoObjects.add(
              new ymaps.Placemark([elem.positionX, elem.positionY], {}, {
                iconLayout: 'default#image',
                iconImageHref: './assets/img/map-marker.svg',
                iconImageSize: iconSize,
                iconImageOffset: iconPosition,
              })
            )
          });
          myMap.behaviors.disable('scrollZoom');
        });
      }
    });
  }
}

export default mapBlock;
