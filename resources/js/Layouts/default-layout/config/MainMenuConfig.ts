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

    {
        heading: 'Provost',
        route: "/students",
        headingRoutes: ["students", 'departments'],
        headingPermissions: ["can-view-student", "can-view-department"],
        pages: [
            {
                sectionTitle: 'Student Management',
                route: "/students",
                keenthemesIcon: "people",
                bootstrapIcon: "bi-archive",
                routeArray: ["/students"],
                routePermissions: ["can-view-student"],
                sub: [
                    {
                        heading: 'Students',
                        route: "/students",
                        permission: "can-view-student",
                    },

                ],
            },

            {
                heading: 'Departments',
                route: "/departments",
                routePermissions: ["can-view-department"],
                // keenthemesIcon: "bank",
                bootstrapIcon: "bi-buildings-fill",
            },

            {
                heading: 'Hall',
                route: "/halls",
                routePermissions: ["can-view-hall"],
                // keenthemesIcon: "bank",
                bootstrapIcon: "bi-building",
            },

            {
                heading: 'Seat Plan',
                route: "/rooms",
                routePermissions: ["can-view-room"],
                // keenthemesIcon: "bank",
                bootstrapIcon: "bi-building-fill-add",
            },

            {
                heading: 'Hall Attachment',
                route: "/hall-attachments",
                routePermissions: ["can-view-hall-attachment"],
                // keenthemesIcon: "bank",
                bootstrapIcon: "bi-building-up",
            },

            {
                heading: 'Hall Allotment',
                route: "/hall-allotments",
                routePermissions: ["can-view-hall-allotment"],
                // keenthemesIcon: "bank",
                bootstrapIcon: "bi-building-fill-check",
            },

        ],
    },
];

export default sidebarMenuConfig;
