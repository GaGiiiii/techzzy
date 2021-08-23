const owl = $('.owl-likes');
const owl2 = $('.owl-comments');
const owl3 = $('.owl-latest');

initG(owl);
initG(owl2);
initG(owl3);

function initG(owl) {
  owl.owlCarousel({
    // nav: true,
    loop: true,
    dots: true,
    margin: 50,
    responsive: {
      0: {
        items: 1,
      },
      565: {
        items: 2,
      },
      991: {
        items: 4,
      },
      1367: {
        items: 5,
      }
    }
  });

  owl.on('mousewheel', '.owl-stage', function (e) {
    if (e.originalEvent.deltaY > 0) {
      owl.trigger('next.owl');
    } else {
      owl.trigger('prev.owl');
    }
    e.preventDefault();
  });
}