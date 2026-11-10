//import '@babel/polyfill'
import 'nodelist-foreach-polyfill'
import { ElementObserver } from 'viewprt'

export const isInView = () => {

  const inViewElements = document.querySelectorAll('.js-in-view')

  if (inViewElements != null) {

    inViewElements.forEach((inViewElement, index) => {
      const factsSliderObserver = ElementObserver(inViewElement, {
        onEnter (element, viewport) {
          element.classList.add('is-in-view')
        },
        once: true,
        offset: 0
      })
    })

  }

}

export const isInViewVideo = () => {

  const inViewVideoElements = document.querySelectorAll('.js-in-view-video')

  if ( inViewVideoElements != null ) {

    inViewVideoElements.forEach((inViewVideoElement, index) => {
      const playVideosObserver = ElementObserver(inViewVideoElement, {
        onEnter (element, viewport) {
          element.querySelector('video').play();
        },
        once: false,
        offset: 0
      })
    })

  }

}
