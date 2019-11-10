import Home from './pages/Home.vue'
import QLSinhvien from './pages/TLDT/QLSinhVien.vue'
import QLGiaoVien from './pages/TLDT/QLGiaoVien.vue'
import QLDeTai from './pages/TLDT/QLDeTai.vue'
import QLDoanhNghiep from './pages/TLDT/QLDoanhNghiep.vue'
import QLThucTap from './pages/TLDT/QLThucTap.vue'
import DKDeTai from './pages/SinhVien/TopicReg.vue'
import DKDoanhNghiep from './pages/SinhVien/CompanyReg.vue'

import InterTime from './components/InternshipTime.vue'
import StudentReg from './components/StudentReg.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },//Trợ Lý Dào tạo
  {
    path: '/QLSinhVien',
    name: 'QLSinhVien',
    component: QLSinhvien
  },
  {
    path: '/QLGiaoVien',
    name: 'QLGiaoVien',
    component: QLGiaoVien
  },
  {
    path: '/QLDeTai',
    name: 'QLDeTai',
    component: QLDeTai
  },
  {
    path: '/QLDoanhNghiep',
    name: 'QLDoanhNghiep',
    component: QLDoanhNghiep
  },
  {
    path: '/QLThucTap',
    name: 'QLThucTap',
    component: QLThucTap,
    redirect:'/QLThucTap/1',
    children:[
      {
        path:':id',
        name:'index',
        component: InterTime
      },
      {
        path:'reg/:id',
        name:'index',
        component: StudentReg
      }
    ]
  }
  ,//sinh viên
  {
    path: '/DKDoanhNghiep',
    name: 'DKDoanhNghiep',
    component: DKDoanhNghiep
  },
  {
    path: '/DKDeTai',
    name: 'DKDeTai',
    component: DKDeTai
  }
  
]
export default routes
