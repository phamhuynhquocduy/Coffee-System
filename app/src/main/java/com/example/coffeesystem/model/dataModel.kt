package com.example.coffeesystem.model
import java.io.Serializable

data class Product(
        val id: Int,
        val name: String?,
        val image: String,
        val description: String,
        val price: Double,
        val idcategory: Int,
        val status: String
) : Serializable

data class User(
        val id: Int,
        val username: String,
        var name: String,
        val email: String,
        val phone: String,
        var address: String
): Serializable

data class Category(
    val id: Int,
    val name: String,
    val image: String,
    val description: String,
    val listProdcut : ArrayList<Product>
): Serializable

data class Cart(
    val idUser: Int,
    val idProduct : Int,
    val name: String,
    val image: String,
    val description: String,
    val price: Double,
    val idcategory: Int,
    val count: Int
): Serializable