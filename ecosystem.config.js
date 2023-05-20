module.exports = {
  apps: [
    {
      name: 'queue',
      interpreter: 'php',
      script: 'artisan',
      instances: 3,
      args: 'queue:work redis --sleep=2 --tries=1'
    },
    {
      name: 'queue-notification',
      interpreter: 'php',
      script: 'artisan',
      instances: 3,
      args: 'queue:work redis --queue=queue-notification --sleep=2 --tries=1',
    },
  ]
};