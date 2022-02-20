import { NavItems } from "~/types/sidebarItem";

export const useNav = () => {
  const items: NavItems = [
    { icon: 'mdi-speedometer', name: 'ダッシュボード', to: '/dashboard' },
    { icon: 'mdi-account', name: 'アカウント管理', to: '/account' },
  ]
  return { items }
}
