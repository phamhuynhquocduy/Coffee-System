package com.example.coffeesystem.ui.home

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.SearchView
import androidx.fragment.app.Fragment
import androidx.recyclerview.widget.LinearLayoutManager
import com.example.coffeesystem.databinding.FragmentHomeBinding
import com.example.coffeesystem.model.Product

class HomeFragment : Fragment() {

    private var _binding: FragmentHomeBinding? = null
    private val binding get() =  _binding!!
    private val mAdapter = ProductAdapter(arrayListOf())
    private val mReceiveOderList = ArrayList<Product>()
    override fun onCreateView(
            inflater: LayoutInflater,
            container: ViewGroup?,
            savedInstanceState: Bundle?
    ): View? {
        _binding = FragmentHomeBinding.inflate(inflater, container, false)
        return binding.root
    }
    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        val receiveOrder = Product(1, "Quận 5 co", "https://www.hudsonvalleysojourner.com/wp-content/uploads/2013/10/Art-Cafe-Latte-Art.jpg", "Dịch vụ: Gói hàng, Bóc vác", 100.000, 1)
        val receiveOrder1 = Product(2, "Quận 1 a", "https://www.hudsonvalleysojourner.com/wp-content/uploads/2013/10/Art-Cafe-Latte-Art.jpg", "Dịch vụ: Gói hàng, Bóc vác",100.000 , 2)
        val receiveOrder2 = Product(3, "Quận 4 bb", "https://www.hudsonvalleysojourner.com/wp-content/uploads/2013/10/Art-Cafe-Latte-Art.jpg", "Dịch vụ: Gói hàng, Bóc vác",150.000,1)
        val receiveOrder3 = Product(3, "Quận 4 ccc", "https://www.hudsonvalleysojourner.com/wp-content/uploads/2013/10/Art-Cafe-Latte-Art.jpg", "Dịch vụ: Gói hàng, Bóc vác",150.000,1)
        val receiveOrder4 = Product(3, "Quận 4 ss", "https://www.hudsonvalleysojourner.com/wp-content/uploads/2013/10/Art-Cafe-Latte-Art.jpg", "Dịch vụ: Gói hàng, Bóc vác",150.000,1)
        val receiveOrder5 = Product(3, "Quận 4 ss", "https://www.hudsonvalleysojourner.com/wp-content/uploads/2013/10/Art-Cafe-Latte-Art.jpg", "Dịch vụ: Gói hàng, Bóc vác",150.000,1)
        val receiveOrder6 = Product(3, "Quận 4 a", "https://www.hudsonvalleysojourner.com/wp-content/uploads/2013/10/Art-Cafe-Latte-Art.jpg", "Dịch vụ: Gói hàng, Bóc vác",150.000,1)
        mReceiveOderList.add(receiveOrder)
        mReceiveOderList.add(receiveOrder1)
        mReceiveOderList.add(receiveOrder2)
        mReceiveOderList.add(receiveOrder3)
        mReceiveOderList.add(receiveOrder4)
        mReceiveOderList.add(receiveOrder5)
        mReceiveOderList.add(receiveOrder6)

        mAdapter.addItems(mReceiveOderList)
        val layoutManager = LinearLayoutManager(requireContext())
        binding.rvListProduct.layoutManager = layoutManager
        binding.rvListProduct.adapter = mAdapter

        searchEvent()

    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }
    private fun searchEvent(){
        binding.searchBar.setOnQueryTextListener(object : SearchView.OnQueryTextListener, androidx.appcompat.widget.SearchView.OnQueryTextListener {
            override fun onQueryTextSubmit(p0: String?): Boolean {
                return false
            }
            override fun onQueryTextChange(p0: String?): Boolean {
                //Start filtering the list as user start entering the characters
                if (p0 != null) {
                    mAdapter.filterName(p0)
                }
                return false
            }
        })
    }
}