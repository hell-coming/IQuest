/* eslint-disable no-console */
import process from 'node:process'
import http from 'node:http'
import express from 'express'
import { setupMockControllers } from './mock'
import config from './mock/config'
import { print } from './mock/utils'

const app = express()

setupMockControllers(app)

const server = http.createServer(app)

server.listen(config.port, () => {
  console.log('\x1B[36m%s\x1B[0m', '---------------------------------------')
  console.log('\x1B[36m%s\x1B[0m', `✨ Mock endpoints enabled on the port`, `${config.port}`)
  console.log('\x1B[36m%s\x1B[0m', '🚀 Node:', process.env.npm_config_user_agent)
  console.log('')
  app._router.stack.forEach(print.bind(null, []))
  console.log('\x1B[36m%s\x1B[0m', '---------------------------------------')
})
