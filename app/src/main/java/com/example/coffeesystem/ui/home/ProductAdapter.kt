package com.example.coffeesystem.ui.home

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.coffeesystem.R
import com.example.coffeesystem.model.Product

class ProductAdapter(val mItems: ArrayList<Product>) :RecyclerView.Adapter<ProductAdapter.CustomViewHolder>()  {
    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ProductAdapter.CustomViewHolder {
        val v = LayoutInflater.from(parent.context)
                .inflate(R.layout.layout_product_item, parent, false)
        return CustomViewHolder(v)
    }

    override fun getItemCount(): Int {
        return mItems.size
    }
    override fun onBindViewHolder(holder: ProductAdapter.CustomViewHolder, position: Int) {
        val item: Product = mItems[position]
        holder.mTvName!!.text = item.name
        }
    inner class CustomViewHolder(itemView: View?) : RecyclerView.ViewHolder(itemView!!) {
        var mTvName = itemView?.findViewById<TextView>(R.id.tv_name)
    }
    fun addItems(items: ArrayList<Product>) {
        mItems.clear()
        mItems.addAll(items)
        notifyDataSetChanged()
    }
    interface ServiceCallback {
        fun onServiceClickCallBack(position: Int, id: String)
    }

}