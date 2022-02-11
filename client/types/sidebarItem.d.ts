// import * as Icons from '@mdi/js'

// export type IconName = keyof typeof Icons;

export interface NavItem {
  to?: string
  name: string
  icon?: string
}

export type NavItems = NavItem[];
