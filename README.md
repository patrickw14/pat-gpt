# PatGPT

## Development

Run event queue listener worker
`php artisan queue:work`

Reverb websocket server startup
`php artisan reverb:start --debug`

Hot-reloading changes
`composer run dev`

Clear and re-seed database
`php artisan migrate:fresh --seed`

Clear cache if necessary
`php artisan cache:clear`