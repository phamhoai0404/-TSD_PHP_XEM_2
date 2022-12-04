import userRoot from './components/user/UserRootComponent'
import playFileRoot from './components/file/FileRootComponent'
import syncFileRoot from './components/sync_file/SyncFileRootComponent'
import microPCRoot from './components/micro_pc/MicroPCRootComponent'
import pcRoot from './components/pc/PCRootComponent'
import departmentRoot from './components/department/DepartmentRootComponent'
import lineRoot from './components/line/LineRootComponent'
import settingRoot from './components/setting/SettingRootComponent'

export default [
    {path: '/user', name: 'userRoot', component: userRoot, meta: { data: 'user root'}},
    {path: '/sync_file', name: 'syncFileRoot', component: syncFileRoot, meta: { data: 'user temp'}},
    {path: '/play_file', name: 'playFileRoot', component: playFileRoot, meta: { data: 'user temp'}},
    {path: '/line', name: 'lineRoot', component: lineRoot, meta: { data: 'user temp'}},
    {path: '/setting', name: 'settingRoot', component: settingRoot, meta: { data: 'user temp'}},
    {path: '/micro_pc', name: 'microPCRoot', component: microPCRoot, meta: { data: 'user temp'}},
    {path: '/pc', name: 'pcRoot', component: pcRoot, meta: { data: 'user temp'}},
    {path: '/department', name: 'departmentRoot', component: departmentRoot, meta: { data: 'user temp'}},

]
