package com.example.coffeesystem.ui.home

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
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

        val receiveOrder = Product(1, "Quận5", "20/11/2020 - Xe tải", "Dịch vụ: Gói hàng, Bóc vác", 100.000, 1)
        val receiveOrder1 = Product(2, "Quận1", "20/11/2020 - Xe tải", "Dịch vụ: Gói hàng, Bóc vác", 100.000 , 2)
        val receiveOrder2 = Product(3, "Quận4", "20/11/2020 - Xe tải", "Dịch vụ: Gói hàng, Bóc vác", 150.000,1)
        val receiveOrder3 = Product(3, "Quận4", "20/11/2020 - Xe tải", "Dịch vụ: Gói hàng, Bóc vác", 150.000,1)
        val receiveOrder4 = Product(3, "Quận4", "20/11/2020 - Xe tải", "Dịch vụ: Gói hàng, Bóc vác", 150.000,1)
        val receiveOrder5 = Product(3, "Quận4", "20/11/2020 - Xe tải", "Dịch vụ: Gói hàng, Bóc vác", 150.000,1)
        val receiveOrder6 = Product(3, "Quận4", "20/11/2020 - Xe tải", "Dịch vụ: Gói hàng, Bóc vác", 150.000,1)
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

    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }
}