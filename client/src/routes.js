import Home from './pages/Home.vue'
import QLSinhvien from './pages/TLDT/QLSinhVien.vue'
import QLGiaoVien from './pages/TLDT/QLGiaoVien.vue'
import QLDeTai from './pages/TLDT/QLDeTai.vue'
import QLDoanhNghiep from './pages/TLDT/QLDoanhNghiep.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
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
    path: '/QLSinhVien',
    name: 'QLSinhVien',
    component: QLSinhvien
  },
  {
    path: '/QLDoanhNghiep',
    name: 'QLDoanhNghiep',
    component: QLDoanhNghiep
  }
]
export default routes
