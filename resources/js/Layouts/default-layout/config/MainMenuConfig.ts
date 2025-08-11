import type {MenuItem} from "@/Layouts/default-layout/config/types";
import i18n from '@/Core/plugins/i18n';

const { t } = i18n.global;

const sidebarMenuConfig: Array<MenuItem> = [
    {
        pages: [
            {
                heading: t('sidebarMenu.dashboard'),
                route: "/dashboard",
                keenthemesIcon: "element-11",
                bootstrapIcon: "bi-app-indicator",
            }
        ],
    },

    {
        heading: t('sidebarMenu.admin'),
        route: "/configurations",
        headingRoutes: ["/configurations", "/roles", "/users", "/permissions", "/companies", "/subscription-plans","/items"],
        headingPermissions: ["can-view-configuration", "can-view-role", "can-view-user", "can-view-permission", "can-view-company", "can-view-subscription-plan","can-view-item"],
        pages: [
            {
                sectionTitle: t('sidebarMenu.userManagement.menu'),
                route: "/users",
                keenthemesIcon: "profile-user",
                bootstrapIcon: "bi-archive",
                routeArray: ["/roles", "/users", "/permissions"],
                routePermissions: ["can-view-role", "can-view-user", "can-view-permission"],
                sub: [
                    {
                        heading: t('sidebarMenu.userManagement.submenu.permissions'),
                        route: "/permissions",
                        permission: "can-view-permission",
                    },
                    {
                        heading: t('sidebarMenu.userManagement.submenu.roles'),
                        route: "/roles",
                        permission: "can-view-role",
                    },
                    {
                        heading: t('sidebarMenu.userManagement.submenu.users'),
                        route: "/users",
                        permission: "can-view-user",
                    },
                ],
            },

        ],
    },
];

export default sidebarMenuConfig;
