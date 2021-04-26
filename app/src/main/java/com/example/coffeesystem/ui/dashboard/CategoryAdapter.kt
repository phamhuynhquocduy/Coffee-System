package com.example.coffeesystem.ui.dashboard

import android.app.Activity
import android.content.Intent
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import android.widget.Toast
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.coffeesystem.R
import com.example.coffeesystem.model.Category
import com.example.coffeesystem.model.Product
import com.example.coffeesystem.ui.dashboard.DashboardFragment.Companion.jsonParse
import com.squareup.picasso.Picasso

class CategoryAdapter(private var mItems: ArrayList<Category>) :
    RecyclerView.Adapter<CategoryAdapter.CustomViewHolder>() {

    private lateinit var mItemProduct: ArrayList<Product>
    private var mAdapterProduct = ProductCategoryAdapter(arrayListOf())

    override fun onCreateViewHolder(
            parent: ViewGroup,
            viewType: Int
    ): CategoryAdapter.CustomViewHolder {
        val v = LayoutInflater.from(parent.context)
            .inflate(R.layout.layout_category, parent, false)
        return CustomViewHolder(v)
    }

    override fun onBindViewHolder(holder: CategoryAdapter.CustomViewHolder, position: Int) {
        val activity = holder.itemView.context as Activity
        val item: Category = mItems[position]
        holder.mTvName!!.text = item.name
        Picasso.get().load(item.image).error(R.drawable.ic_launcher_background)
            .into(holder.mImage)
        holder.itemView.setOnClickListener(){
            val intent = Intent(activity, ListProductActivity::class.java)
            intent.putExtra("id", item.id)
            Toast.makeText(activity, item.id.toString(), Toast.LENGTH_SHORT).show()
            activity.startActivity(intent)
        }
        mAdapterProduct.addItems(item.listProdcut)
       Log.e("ddddddd",item.listProdcut.toString())

        val layoutManager = LinearLayoutManager(activity)
        holder.mRecyclerView?.layoutManager = layoutManager
        holder.mRecyclerView?.adapter = mAdapterProduct
    }

    override fun getItemCount(): Int {
        return mItems.size
    }
    inner class CustomViewHolder(itemView: View?) : RecyclerView.ViewHolder(itemView!!) {
        var mTvName = itemView?.findViewById<TextView>(R.id.tv_category)
        var mImage  =itemView?.findViewById<ImageView>(R.id.img_category)
        var mRecyclerView  =itemView?.findViewById<RecyclerView>(R.id.rv_list_product)

    }
    fun addItems(items: ArrayList<Category>) {
        mItems.clear()
        mItems.addAll(items)

        notifyDataSetChanged()
    }
}