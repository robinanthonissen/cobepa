import '@babel/polyfill'
import 'nodelist-foreach-polyfill'
import { ElementObserver } from 'viewprt'

const isInViewVideo = () => {

  const inViewVideoElements = document.querySelectorAll('.js-video-in-view')

  if ( inViewVideoElements != null ) {

    inViewVideoElements.forEach((inViewVideoElement, index) => {
      const playVideosObserver = ElementObserver(inViewVideoElement, {
        onEnter (element, viewport) {
          element.querySelector('video').play();
        },
        once: false,
        offset: -200
      })
    })

  }

}

export default isInViewVideo
