(() => {
  const target = document.querySelector('body > div.container')
  target.querySelector(':scope > div > div:nth-child(2)').style.minHeight = target.style.minHeight = (self.innerHeight - 120) + 'px'
})()

document
  .querySelectorAll('a[data-toggle="button"]')
  .forEach(a => a.addEventListener('click', ({ target }) => {
    const { classList } = target.closest('div.container').querySelector(':scope > div[role="contentinfo"]')
    const state = classList.contains('d-none')

    target.style.opacity = true !== state ? .5 : 1;
    (true !== state || classList.remove('d-none')) && classList.add('d-none')
  }));

(container => {
  const { app } = container

  if (app === undefined) {
    return console.info('App context is undefined.')
  }

  const { deferredEvents } = app

  deferredEvents.forEach(({ panelId, handle }) => {
    handle.apply(null, [{ panelId }])
  })
})(window)
