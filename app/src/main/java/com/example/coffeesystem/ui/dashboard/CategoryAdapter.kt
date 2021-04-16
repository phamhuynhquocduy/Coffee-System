package com.example.coffeesystem.ui.dashboard

import android.app.Activity
import android.content.Intent
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.coffeesystem.DetailProductActivity
import com.example.coffeesystem.R
import com.example.coffeesystem.model.Category
import com.example.coffeesystem.model.Product
import com.squareup.picasso.Picasso
import java.text.DecimalFormat

class CategoryAdapter (private var mItems: ArrayList<Category>) :
    RecyclerView.Adapter<CategoryAdapter.CustomViewHolder>() {
    override fun onCreateViewHolder(
        parent: ViewGroup,
        viewType: Int
    ): CategoryAdapter.CustomViewHolder {
        val v = LayoutInflater.from(parent.context)
            .inflate(R.layout.layout_category, parent, false)
        return CustomViewHolder(v)
    }

    override fun onBindViewHolder(holder: CategoryAdapter.CustomViewHolder, position: Int) {
        val item: Category = mItems[position]
        holder.mTvName!!.text = item.name
        Picasso.get().load(item.image).error(R.drawable.ic_launcher_background)
            .into(holder.mImage)
        holder.itemView.setOnClickListener(){
            val activity = holder.itemView.context as Activity
            val intent = Intent(activity, ListProductActivity::class.java)
            intent.putExtra("id",item.id)
            activity.startActivity(intent)

        }
    }

    override fun getItemCount(): Int {
        return mItems.size
    }
    inner class CustomViewHolder(itemView: View?) : RecyclerView.ViewHolder(itemView!!) {
        var mTvName = itemView?.findViewById<TextView>(R.id.tv_category)
        var mImage  =itemView?.findViewById<ImageView>(R.id.img_category)
    }
    fun addItems(items: ArrayList<Category>) {
        mItems.clear()
        mItems.addAll(items)

        notifyDataSetChanged()
    }
}