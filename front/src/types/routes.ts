export enum EAppRouteNames {
  Home = 'Quests',
  Quest = 'Quest',
  Contacts = 'Contacts',
  Certificat = 'Certificat',
  Holidays = 'Holidays',
  Lounge = 'Lounge',
  NotFound = 'NotFound',
}

export enum EAppRoutePaths {
  Home = '/',
  Quest = '/quest/:id',
  Contacts = '/contacts',
  Certificat = '/certificat',
  Holidays = '/holidays/:id',
  Lounge = '/lounge',
  NotFound = '/:pathMatch(.*)*',
}
