export interface ILayer {
  route?: { path: string, stack: ILayer[] }
  name?: string
  handle?: { stack: ILayer[] }
  method?: string
  regexp: string
}

export function print(path: string[], layer: ILayer): void {
  if (layer.route) {
    layer.route.stack.forEach(print.bind(null, path.concat(layer.route.path.split?.('/'))))
  }
  else if (layer.name === 'router' && layer?.handle?.stack) {
    layer.handle.stack.forEach(print.bind(null, path.concat(layer.regexp.split?.('/'))))
  }
  else if (layer.method) {
    // eslint-disable-next-line no-console
    console.log(
      '\x1B[34m%s /%s',
      layer.method.toUpperCase(),
      path.concat(layer.regexp.split?.('/')).filter(Boolean).join('/'),
    )
  }
}
