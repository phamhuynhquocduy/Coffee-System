package com.example.coffeesystem.model
import java.io.Serializable

data class Product(
        val id: Int,
        val name: String?,
        val image: String,
        val description: String,
        val price: Double,
        val idcategory: Int
) : Serializable

data class User(
    val id: Int,
    val username: String,
    val name: String,
    val email: String,
    val phone: String,
    val address: String
): Serializable{
    companion object{
        fun getInstance(id: Int,username: String,name: String,email: String,phone: String,address: String) : User = User(id, username, name, email, phone, address)
        fun getUser () : Companion {
            return this
        }
    }
}